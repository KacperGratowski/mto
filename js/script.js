function toggleChat() {
    var popup = document.getElementById('chat-popup');
    if (popup.style.display === 'block') {
        popup.style.display = 'none';
    } else {
        popup.style.display = 'block';
    }
}

function closePopup() {
    document.getElementById('chat-popup').style.display = 'none';
}
