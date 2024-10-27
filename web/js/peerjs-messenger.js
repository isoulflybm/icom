window.addEventListener('load', () => {
	peer = new Peer();
	peer.on('open', (id) => {
		console.log('Open ID ' + id);
        peer.connect(id);
	});
    peer.on('connect', (connection) => {
    });
    peer.on('call', (media) => {
    });
});
