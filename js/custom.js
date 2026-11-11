// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var el = document.querySelector("#displayYear");
    if (el) el.innerHTML = currentYear;
}

getYear();

// nice select
$(document).ready(function () {
    if ($.fn.niceSelect) $('select').niceSelect();
});

// date picker

// owl carousel slider js
if ($.fn.owlCarousel) $('.team_carousel').owlCarousel({
    loop: true,
    margin: 15,
    dots: true,
    autoplay: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1,
            margin: 0
        },
        576: {
            items: 2,
        },
        992: {
            items: 3
        }
    }
});

// ---------- Mode demo (versi online tanpa PHP) ----------
(function () {
    var isStatic = !/^(localhost|127\.0\.0\.1)$/.test(location.hostname) && location.protocol !== 'file:';

    // tanggal janji temu minimal hari ini
    var d = document.getElementById('inputDate');
    if (d) { var t = new Date(); d.min = t.toISOString().slice(0, 10); }

    function notice(title, msg) {
        var old = document.getElementById('demoNotice');
        if (old) old.remove();
        var box = document.createElement('div');
        box.id = 'demoNotice';
        box.className = 'demo-notice';
        box.setAttribute('role', 'dialog');
        box.innerHTML = '<div class="demo-card"><h4></h4><p></p><button type="button">Mengerti</button></div>';
        box.querySelector('h4').textContent = title;
        box.querySelector('p').textContent = msg;
        box.addEventListener('click', function (e) { if (e.target === box || e.target.tagName === 'BUTTON') box.remove(); });
        document.body.appendChild(box);
        box.querySelector('button').focus();
    }

    // langganan berita
    document.querySelectorAll('.js-subscribe').forEach(function (f) {
        f.addEventListener('submit', function (e) {
            e.preventDefault();
            var email = f.querySelector('input[type=email]');
            if (!email || !email.value || !email.checkValidity()) { email && email.reportValidity(); return; }
            notice('Terima kasih!', 'Email ' + email.value + ' sudah terdaftar untuk menerima info kesehatan dari Yamazaki Hospital.');
            f.reset();
        });
    });

    if (!isStatic) return;

    // formulir yang butuh PHP
    document.querySelectorAll('form[action$=".php"]').forEach(function (f) {
        f.addEventListener('submit', function (e) {
            e.preventDefault();
            var isBooking = /book_appointment/.test(f.getAttribute('action'));
            var name = f.querySelector('[name=patient_name],[name=full_name]');
            notice(isBooking ? 'Janji temu tercatat (demo)' : 'Pesan terkirim (demo)',
                (name && name.value ? 'Terima kasih, ' + name.value + '. ' : '') +
                'Ini versi demo statis, jadi data tidak disimpan. Versi lengkap menyimpan data ke MySQL lewat PHP dan bisa dikelola dari panel admin.');
            f.reset();
        });
    });

    // tautan ke panel admin PHP
    document.querySelectorAll('a[href$=".php"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            notice('Panel admin', 'Panel admin memakai PHP + MySQL sehingga hanya berjalan di server lokal (XAMPP). Lihat README di GitHub untuk cara menjalankannya.');
        });
    });
})();
