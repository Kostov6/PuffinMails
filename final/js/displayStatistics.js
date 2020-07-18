window.onload = function () {
    document.getElementById('average_len').textContent = statistics['averageChars'];
    document.getElementById('all_msg_count').textContent = statistics['messageCount'];
    document.getElementById('non_anon_count').textContent = statistics['normalMsgCount'];
    document.getElementById('rec_msg_count').textContent = statistics['recMsgCount'];
    document.getElementById('group_msg_count').textContent = statistics['groupMsgCount'];
    document.getElementById('seen_percentage').textContent = statistics['seenPercentage'];
};