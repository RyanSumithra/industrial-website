<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

require_once '../includes/config.php';
require_once '../includes/db.php';

// --- CONFIGURATION ---
define('SENDER_EMAIL', 'info@techasiamechatronics.com'); // Updates the sender email here

// --- ACTION HANDLER ---
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id > 0) {
        if ($_GET['action'] === 'delete') $conn->query("DELETE FROM inquiries WHERE id=$id");
        elseif ($_GET['action'] === 'read') $conn->query("UPDATE inquiries SET status='read', read_at=NOW() WHERE id=$id");
        elseif ($_GET['action'] === 'unread') $conn->query("UPDATE inquiries SET status='unread', read_at=NULL WHERE id=$id");
    }
    header('Location: inquiries.php'); exit;
}

// --- BULK ACTIONS ---
if (isset($_POST['bulk_action'], $_POST['ids'])) {
    $ids = implode(',', array_map('intval', $_POST['ids']));
    if ($_POST['bulk_action'] === 'delete') $conn->query("DELETE FROM inquiries WHERE id IN ($ids)");
    elseif ($_POST['bulk_action'] === 'read') $conn->query("UPDATE inquiries SET status='read', read_at=NOW() WHERE id IN ($ids)");
    header('Location: inquiries.php'); exit;
}

// --- SEND REPLY HANDLER ---
if (isset($_POST['send_reply'])) {
    $to = $_POST['reply_to'];
    $subject = $_POST['reply_subject'];
    $message = nl2br($_POST['reply_message']);
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: AsiaTech <" . SENDER_EMAIL . ">" . "\r\n";
    
    if(mail($to, $subject, $message, $headers)) {
        // Auto-mark as read upon reply
        $inquiry_id = intval($_POST['inquiry_id']);
        $conn->query("UPDATE inquiries SET status='read', read_at=NOW() WHERE id=$inquiry_id");
        $msg = "Reply sent successfully to $to";
        $msg_type = "success";
    } else {
        $msg = "Failed to send email. Check server logs.";
        $msg_type = "error";
    }
}

// --- FILTERS & DATA ---
$where = [];
if (!empty($_GET['s'])) {
    $s = $conn->real_escape_string($_GET['s']);
    $where[] = "(name LIKE '%$s%' OR email LIKE '%$s%' OR message LIKE '%$s%')";
}
if (!empty($_GET['status'])) $where[] = "status = '".$conn->real_escape_string($_GET['status'])."'";
if (!empty($_GET['type'])) $where[] = ($_GET['type'] === 'product') ? "product_name != ''" : "product_name = ''";

$sql_where = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";

// Pagination
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 15; 
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) as c FROM inquiries $sql_where")->fetch_assoc()['c'];
$pages = ceil($total / $limit);
$result = $conn->query("SELECT * FROM inquiries $sql_where ORDER BY created_at DESC LIMIT $limit OFFSET $offset");

// Stats
$stats = $conn->query("SELECT COUNT(*) as total, SUM(status='unread') as unread FROM inquiries")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inquiries | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #ff3333; --accent-dim: rgba(255, 51, 51, 0.08);
            --bg: #050505; --surface: #111; --border: #222; --text: #f0f0f0; --text-muted: #888;
            --input: #0a0a0a; --hover: #161616;
        }
        body.light-mode {
            --bg: #f8fafc; --surface: #ffffff; --border: #e2e8f0; --text: #0f172a; --text-muted: #64748b;
            --input: #f1f5f9; --hover: #f8fafc;
        }

        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; margin: 0; padding: 0; transition: 0.3s; }
        .layout { max-width: 1400px; margin: 0 auto; padding: 40px 20px; }
        * { box-sizing: border-box; } a { text-decoration: none; }

        /* HEADER */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { font-size: 1.5rem; font-weight: 600; margin: 0; letter-spacing: -0.5px; }
        .nav-link { color: var(--text-muted); font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; gap: 5px; }
        .nav-link:hover { color: var(--accent); }

        /* ALERT */
        .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; text-align: center; }
        .alert-success { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.2); }
        .alert-error { background: rgba(255, 51, 51, 0.1); color: #ff3333; border: 1px solid rgba(255, 51, 51, 0.2); }

        /* STATS */
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px; }
        .stat-card { background: var(--surface); padding: 20px; border-radius: 12px; border: 1px solid var(--border); }
        .stat-num { font-size: 1.8rem; font-weight: 600; display: block; line-height: 1; margin-bottom: 5px; }
        .stat-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }

        /* TOOLBAR */
        .toolbar { background: var(--surface); padding: 15px; border-radius: 12px; border: 1px solid var(--border); display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; align-items: center; }
        .input { background: var(--input); border: 1px solid var(--border); color: var(--text); padding: 10px 14px; border-radius: 8px; font-size: 0.9rem; outline: none; transition: 0.2s; }
        .input:focus { border-color: var(--accent); }
        .search-box { flex-grow: 1; min-width: 200px; }
        
        .btn { padding: 10px 20px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; border: 1px solid transparent; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-outline { background: transparent; border-color: var(--border); color: var(--text); }
        .btn-outline:hover { background: var(--hover); }
        
        /* TABLE */
        .table-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { text-align: left; padding: 16px 20px; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; background: var(--input); font-weight: 600; }
        td { padding: 16px 20px; border-bottom: 1px solid var(--border); font-size: 0.9rem; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--hover); }
        
        .row-unread td { background: rgba(255, 51, 51, 0.02); }
        .row-unread .sender { font-weight: 700; color: var(--text); }
        .row-unread .status-dot { background: var(--accent); box-shadow: 0 0 6px var(--accent); }

        .status-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--border); margin-right: 8px; }
        .sender { color: var(--text); display: block; margin-bottom: 4px; }
        .email { color: var(--text-muted); font-size: 0.8rem; font-family: 'JetBrains Mono'; }
        .preview { color: var(--text-muted); font-size: 0.9rem; margin-top: 4px; display: block; cursor: pointer; }
        .preview:hover { color: var(--text); }
        .tag { font-size: 0.75rem; padding: 4px 8px; border-radius: 6px; background: var(--input); border: 1px solid var(--border); color: var(--text-muted); display: inline-block; white-space: nowrap; }
        .tag-prod { color: var(--text); border-color: var(--border); }

        .actions { display: flex; gap: 5px; justify-content: flex-end; }
        .act-btn { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; color: var(--text-muted); transition: 0.2s; }
        .act-btn:hover { background: var(--hover); color: var(--text); }
        .act-del:hover { background: var(--accent-dim); color: var(--accent); }

        /* MODAL */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; }
        .modal-box { background: var(--surface); width: 600px; max-width: 90%; border-radius: 16px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
        .modal-header { padding: 20px 25px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .modal-body { padding: 25px; }
        .modal-footer { padding: 20px 25px; border-top: 1px solid var(--border); background: var(--input); display: flex; justify-content: flex-end; gap: 10px; }
        
        /* View Mode */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .info-label { font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 6px; }
        .info-val { font-size: 0.95rem; color: var(--text); }
        .msg-box { background: var(--input); padding: 15px; border-radius: 8px; border: 1px solid var(--border); color: var(--text); line-height: 1.6; white-space: pre-wrap; font-size: 0.95rem; }

        /* Reply Mode */
        .reply-form { display: none; }
        .reply-field { margin-bottom: 15px; }
        .reply-label { display: block; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px; }
        .reply-input { width: 100%; padding: 10px; background: var(--input); border: 1px solid var(--border); color: var(--text); border-radius: 6px; }
        .reply-textarea { min-height: 150px; resize: vertical; }

        @media(max-width:768px) { .layout { padding: 15px; } .header, .toolbar { flex-direction: column; align-items: stretch; } .stats { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="layout">
    
    <div class="header">
        <div>
            <a href="dashboard.php" class="nav-link">← Dashboard</a>
            <h1>Inquiry Log</h1>
        </div>
        <div style="display:flex; gap:10px">
            <button class="btn btn-outline" onclick="toggleTheme()">☀</button>
            <button class="btn btn-primary" onclick="exportCSV()">↓ Export CSV</button>
        </div>
    </div>

    <?php if(isset($msg)): ?>
        <div class="alert alert-<?= $msg_type ?>"><?= $msg ?></div>
    <?php endif; ?>

    <div class="stats">
        <div class="stat-card">
            <span class="stat-num"><?= number_format($stats['total']) ?></span>
            <span class="stat-label">Total Inquiries</span>
        </div>
        <div class="stat-card">
            <span class="stat-num" style="color: <?= $stats['unread']>0 ? 'var(--accent)' : 'inherit' ?>"><?= number_format($stats['unread']) ?></span>
            <span class="stat-label">Unread Messages</span>
        </div>
    </div>

    <form method="GET" class="toolbar">
        <input type="text" name="s" class="input search-box" value="<?= htmlspecialchars($_GET['s']??'') ?>" placeholder="Search name, email, content...">
        <select name="status" class="input" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="unread" <?= ($_GET['status']??'')=='unread'?'selected':'' ?>>Unread</option>
            <option value="read" <?= ($_GET['status']??'')=='read'?'selected':'' ?>>Read</option>
        </select>
        <select name="type" class="input" onchange="this.form.submit()">
            <option value="">All Types</option>
            <option value="product" <?= ($_GET['type']??'')=='product'?'selected':'' ?>>Product Related</option>
            <option value="general" <?= ($_GET['type']??'')=='general'?'selected':'' ?>>General</option>
        </select>
        <a href="inquiries.php" class="btn btn-outline">Reset</a>
    </form>

    <form method="POST" class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th width="40"><input type="checkbox" onclick="document.querySelectorAll('.chk').forEach(c=>c.checked=this.checked)"></th>
                        <th width="250">Sender</th>
                        <th>Message</th>
                        <th>Context</th>
                        <th>Date</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
                    <tr class="<?= $row['status']=='unread' ? 'row-unread' : '' ?>">
                        <td style="text-align:center;"><input type="checkbox" name="ids[]" value="<?= $row['id'] ?>" class="chk"></td>
                        <td>
                            <span class="sender"><?= htmlspecialchars($row['name']) ?></span>
                            <span class="email"><?= htmlspecialchars($row['email']) ?></span>
                        </td>
                        <td onclick="openModal(<?= htmlspecialchars(json_encode($row)) ?>)" style="cursor: pointer;">
                            <span class="status-dot"></span>
                            <span class="preview"><?= mb_strimwidth(htmlspecialchars($row['message']), 0, 60, "...") ?></span>
                        </td>
                        <td>
                            <?php if($row['product_name']): ?>
                                <span class="tag tag-prod">📦 <?= htmlspecialchars($row['product_name']) ?></span>
                            <?php else: ?>
                                <span class="tag">General</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:0.85rem; color:var(--text-muted);">
                            <?= date('M j', strtotime($row['created_at'])) ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="#" onclick="openModal(<?= htmlspecialchars(json_encode($row)) ?>); switchMode('reply'); return false;" class="act-btn" title="Reply">↩</a>
                                <a href="?action=<?= $row['status']=='unread'?'read':'unread' ?>&id=<?= $row['id'] ?>" class="act-btn" title="Mark Read/Unread">
                                    <?= $row['status']=='unread' ? '✓' : '○' ?>
                                </a>
                                <a href="?action=delete&id=<?= $row['id'] ?>" class="act-btn act-del" onclick="return confirm('Delete?')" title="Delete">✕</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="6" style="text-align:center; padding:40px; color:var(--text-muted);">No inquiries found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="padding:15px; border-top:1px solid var(--border); display:flex; gap:10px; align-items:center;">
            <span style="font-size:0.85rem; color:var(--text-muted);">Selected:</span>
            <button name="bulk_action" value="read" class="btn btn-outline" style="padding:6px 12px; font-size:0.8rem;">Mark Read</button>
            <button name="bulk_action" value="delete" class="btn btn-outline" style="padding:6px 12px; font-size:0.8rem; color:var(--accent); border-color:var(--accent);">Delete</button>
            
            <?php if($pages > 1): ?>
            <div style="margin-left:auto; display:flex; gap:5px;">
                <?php for($i=1; $i<=$pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="btn btn-outline" style="padding:6px 12px; <?= $i==$page?'background:var(--accent);color:white;border-color:var(--accent);':'' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
    </form>

</div>

<div id="modal" class="modal" onclick="if(event.target==this)closeModal()">
    <div class="modal-box">
        <div class="modal-header">
            <h3 style="margin:0;">Inquiry Actions</h3>
            <button onclick="closeModal()" style="background:none; border:none; color:var(--text-muted); font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <div class="modal-body" id="viewMode">
            <div class="info-grid">
                <div><div class="info-label">Sender</div><div class="info-val" id="m_name"></div></div>
                <div><div class="info-label">Email</div><div class="info-val" id="m_email" style="font-family:'JetBrains Mono'"></div></div>
                <div><div class="info-label">Phone</div><div class="info-val" id="m_phone"></div></div>
                <div><div class="info-label">Interest</div><div class="info-val" id="m_prod" style="color:var(--accent)"></div></div>
            </div>
            <div class="info-label">Message</div>
            <div class="msg-box" id="m_msg"></div>
        </div>

        <form method="POST" class="modal-body reply-form" id="replyMode">
            <input type="hidden" name="inquiry_id" id="r_id">
            <div class="reply-field">
                <label class="reply-label">To:</label>
                <input type="email" name="reply_to" id="r_to" class="reply-input" readonly>
            </div>
            <div class="reply-field">
                <label class="reply-label">Subject:</label>
                <input type="text" name="reply_subject" id="r_subject" class="reply-input">
            </div>
            <div class="reply-field">
                <label class="reply-label">Message:</label>
                <textarea name="reply_message" class="reply-input reply-textarea" placeholder="Write your reply here..."></textarea>
            </div>
            <button type="submit" name="send_reply" class="btn btn-primary" style="width:100%">Send Email</button>
        </form>

        <div class="modal-footer" id="viewFooter">
            <button onclick="closeModal()" class="btn btn-outline">Close</button>
            <button onclick="switchMode('reply')" class="btn btn-primary">Reply via Email</button>
        </div>
        <div class="modal-footer reply-form" id="replyFooter">
            <button onclick="switchMode('view')" class="btn btn-outline">Cancel</button>
        </div>
    </div>
</div>

<script>
    // Theme Logic
    if(localStorage.getItem('theme')==='light') document.body.classList.add('light-mode');
    function toggleTheme() {
        document.body.classList.toggle('light-mode');
        localStorage.setItem('theme', document.body.classList.contains('light-mode') ? 'light' : 'dark');
    }

    // Modal Logic
    let currentData = null;

    function openModal(data) {
        currentData = data;
        
        // Populate View Mode
        document.getElementById('m_name').innerText = data.name;
        document.getElementById('m_email').innerText = data.email;
        document.getElementById('m_phone').innerText = data.phone || '-';
        document.getElementById('m_prod').innerText = data.product_name || 'General Inquiry';
        document.getElementById('m_msg').innerText = data.message;
        
        // Populate Reply Mode
        document.getElementById('r_id').value = data.id;
        document.getElementById('r_to').value = data.email;
        document.getElementById('r_subject').value = "Re: Inquiry regarding " + (data.product_name || "your message");
        
        switchMode('view');
        document.getElementById('modal').style.display = 'flex';
    }

    function switchMode(mode) {
        if(mode === 'reply') {
            document.getElementById('viewMode').style.display = 'none';
            document.getElementById('viewFooter').style.display = 'none';
            document.getElementById('replyMode').style.display = 'block';
            document.getElementById('replyFooter').style.display = 'flex';
        } else {
            document.getElementById('viewMode').style.display = 'block';
            document.getElementById('viewFooter').style.display = 'flex';
            document.getElementById('replyMode').style.display = 'none';
            document.getElementById('replyFooter').style.display = 'none';
        }
    }

    function closeModal() { document.getElementById('modal').style.display = 'none'; }

    // Export Logic
    function exportCSV() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = 'export_inquiries.php?' + params.toString();
    }
</script>

</body>
</html>