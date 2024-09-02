document.addEventListener("DOMContentLoaded", function() {
    // Membuat elemen footer
    var footer = document.createElement("footer");
    footer.className = "footer text-black text-center py-3";
    footer.style.backgroundColor = "transparent"; // Background transparan
    footer.innerHTML = '&copy; nurafihsn All Rights Reserved.';

    // Menambahkan footer ke body
    document.body.appendChild(footer);
});
