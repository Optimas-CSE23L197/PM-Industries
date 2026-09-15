// loader.js

(function () {

    // Create loader HTML
    const loader = document.createElement("div");
    loader.id = "page-loader";

    // Get the full URL of loader.js as loaded by the current page
    const scriptSrc = document.currentScript ? document.currentScript.src : '';

    // Resolve the image path relative to loader.js (goes up one level from 'js/' to 'dist/', then into 'img/')
    const loaderImgSrc = scriptSrc
        ? new URL('../img/loader.gif', scriptSrc).href
        : 'dist/img/loader.gif';

    loader.innerHTML = `
    <div class="loader-content">
        <img src="${loaderImgSrc}" alt="Loading...">
    </div>
`;

    document.body.appendChild(loader);

    // CSS
    const style = document.createElement("style");
    style.innerHTML = `
        #page-loader{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100vh;
            background:#F1F1F1;
            display:flex;
            justify-content:center;
            align-items:center;
            z-index:999999;
            transition:opacity .4s ease;
        }

        #page-loader.hide{
            opacity:0;
            visibility:hidden;
        }

        #page-loader img{
            width:100%;
            height:auto;
        }
    `;
    document.head.appendChild(style);

    // Hide loader after page is loaded
    window.addEventListener("load", function () {
        setTimeout(function () {
            document.getElementById("page-loader").classList.add("hide");
        }, 300);
    });

})();