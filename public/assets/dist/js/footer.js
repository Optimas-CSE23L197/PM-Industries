const currentYear = new Date().getFullYear();

document.getElementById("footer-container").innerHTML = `
<footer class="main-footer text-xs">
    Copyright &copy; ${currentYear}
    <strong>PM Industries</strong>
    |
    Powered by
    <a href="https://abatechcal.com" target="_blank">
        <b>Abatech Solutions</b>
    </a>
</footer>
`;