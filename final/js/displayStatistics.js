window.onload = function () {
    document.getElementById('average_len').textContent = statistics['averageChars'];
    document.getElementById('all_msg_count').textContent = statistics['messageCount'];
    document.getElementById('non_anon_count').textContent = statistics['normalMsgCount'];
    document.getElementById('rec_msg_count').textContent = statistics['recMsgCount'];
    document.getElementById('group_msg_count').textContent = statistics['groupMsgCount'];
    document.getElementById('seen_percentage').textContent = statistics['seenPercentage'];
    document.getElementById('most_msg_group').textContent = statistics['groupMostMsgs'];
    document.getElementById('most_msg_for_group').textContent = statistics['mostGroupMsgs'];
    document.getElementById('most_rec_theme').textContent = statistics['mostRecTheme'];
    document.getElementById('most_rec_for_theme').textContent = statistics['mostRecOnTheme'];
    document.getElementById('user_most_msg').textContent = statistics['userMostMsgSent'];
};