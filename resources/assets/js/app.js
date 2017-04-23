(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-45569214-4', 'auto');
ga('send', 'pageview');

$('#myTabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
})

if (!Cookies.get('donateModal')) {
    setTimeout(function () {
        $('#donateModal').modal();
    });
}

$('#donateModal').on('show.bs.modal', function () {
    Cookies.set('donateModal', 'valid', {expires: 15, path: "/"});
})