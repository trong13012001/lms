document.getElementById("filterForm").addEventListener('submit', (ev) => {
    ev.preventDefault()
    var data = new FormData(ev.currentTarget);
    var queryParts = [];
    var entries = data.entries()
    for(var pair of entries)
        queryParts.push(encodeURIComponent(pair[0]) + "=" + encodeURIComponent(pair[1]))
    var query = queryParts.join("&")
    var loc = window.location;

    const params = new URLSearchParams(query);
    [...params.entries()].forEach(([key, value]) => {
        if (!value) {
            params.delete(key);
        }
    });
    const cleaned = String(params) ? `?${String(params)}` : '';
    window.location.href = loc.protocol+'//'+loc.host+loc.pathname+ cleaned;
})

