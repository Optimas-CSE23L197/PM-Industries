// const sidebarHTML = `
// <aside class="main-sidebar sidebar-light-dark elevation-4">
//     <!-- Brand Logo -->
//     <span class="brand-link bg-light py-2">
//         <img src="../dist/img/logo.png" class="brand-image ml-2">
//         <span class="brand-text font-weight-bold">
//             PM Industries
//         </span>
//     </span>
//     <!-- Sidebar Menu -->
//     <div class="sidebar text-sm">
//         <nav class="mt-2">
//             <ul class="nav nav-flat nav-sidebar flex-column" data-widget="treeview" role="menu"
//                 data-accordion="false">
//                 <li class="nav-item">
//                     <a href="dashboard_crm.html" class="nav-link">
//                         <i class="nav-icon fas fa-chart-line"></i>
//                         <p>
//                             Dashboard
//                         </p>
//                     </a>
//                 </li>
//                 <li class="nav-item">
//                     <a href="#" class="nav-link">
//                         <i class="nav-icon fas fa-indian-rupee"></i>
//                         <p>
//                             Transactions
//                             <i class="right fas fa-caret-down"></i>
//                         </p>
//                     </a>
//                     <ul class="nav nav-treeview">
//                         <li class="nav-item">
//                             <a href="enquiry.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Enquiry</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="enquiry_followup.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Enquiry Followup</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="quotation.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Quotation</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="quotation_followup.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Quotation Followup</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="sale.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Sales</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="sale_return.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Sales Return</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="receipt.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Receipt</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="receipt_followup.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Receipt Followup</p>
//                             </a>
//                         </li>
//                     </ul>
//                 </li>
//                 <li class="nav-item">
//                     <a href="#" class="nav-link">
//                         <i class="nav-icon fas fa-file-lines"></i>
//                         <p>
//                             Reports
//                             <i class="right fas fa-caret-down"></i>
//                         </p>
//                     </a>
//                     <ul class="nav nav-treeview">
//                         <li class="nav-item">
//                             <a href="#" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Something</p>
//                             </a>
//                         </li>
//                     </ul>
//                 </li>
//                 <li class="nav-item">
//                     <a href="#" class="nav-link">
//                         <i class="nav-icon fas fa-edit"></i>
//                         <p>
//                             Masters
//                             <i class="right fas fa-caret-down"></i>
//                         </p>
//                     </a>
//                     <ul class="nav nav-treeview">
//                         <li class="nav-item">
//                             <a href="customer.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Customer</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="lead_source.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Lead Source</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="tnc.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Terms & Conditions</p>
//                             </a>
//                         </li>
//                         <li class="nav-item">
//                             <a href="price_list.html" class="nav-link">
//                                 <i class="fas fa-caret-right nav-icon"></i>
//                                 <p>Price List</p>
//                             </a>
//                         </li>
//                     </ul>
//                 </li>
//             </ul>
//         </nav>
//     </div>
// </aside>
// `;
// document.getElementById("sidebar-container").innerHTML = sidebarHTML;

// Menu Active
function setActiveMenu() {
    // Get current page
    let currentPage = window.location.pathname.split("/").pop();

    // If page is empty, use dashboard
    if (!currentPage) {
        currentPage = "dashboard_crm.html";
    }

    // Remove query string and hash
    currentPage = currentPage.split("?")[0].split("#")[0];

    // Remove .html extension
    let pageName = currentPage.replace(/\.html$/i, "");

    // Remove common suffixes
    pageName = pageName.replace(/_details$/i, "").replace(/_print$/i, "");

    // Remove previous active/open classes
    document.querySelectorAll(".nav-link.active").forEach(function (link) {
        link.classList.remove("active");
    });

    // Check every menu link
    document
        .querySelectorAll(".nav-sidebar a.nav-link[href]")
        .forEach(function (link) {
            let href = link.getAttribute("href");

            if (!href || href === "#") {
                return;
            }

            // Remove query string and hash
            href = href.split("?")[0].split("#")[0];

            // Get only filename
            let linkPage = href.split("/").pop();

            // Remove extension
            linkPage = linkPage.replace(/\.html$/i, "");

            // Remove common suffixes
            linkPage = linkPage
                .replace(/_details$/i, "")
                .replace(/_print$/i, "");

            // Match current page
            if (linkPage === pageName) {
                // Make current menu active
                link.classList.add("active");

                // Open ALL parent menu levels
                let parentTree = link.closest(".nav-treeview");

                while (parentTree) {
                    // Find the parent nav-item
                    let parentItem = parentTree.closest(".nav-item");

                    if (!parentItem) {
                        break;
                    }

                    // Activate parent menu
                    let parentLink =
                        parentItem.querySelector(":scope > .nav-link");

                    if (parentLink) {
                        parentLink.classList.add("active");
                    }

                    // Move to next parent level
                    parentTree =
                        parentItem.parentElement.closest(".nav-treeview");
                }
            }
        });
}

// Run after sidebar has been inserted
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setActiveMenu);
} else {
    setActiveMenu();
}

// Page Title
const appTitle = "PM Industries";
document.addEventListener("DOMContentLoaded", function () {
    let pageTitle = "";
    // Details pages: Unit > Details
    const breadcrumbLink = document.querySelector(".content-header a");
    if (breadcrumbLink) {
        pageTitle = breadcrumbLink.textContent.trim();
    } else {
        // List pages: <span class="text-bold">Unit</span>
        const headerTitle = document.querySelector(
            ".content-header .text-bold",
        );
        if (headerTitle) {
            pageTitle = headerTitle.textContent.trim();
        }
    }
    document.title = (pageTitle || "PM Industries") + " | " + appTitle;
});

// Inject Favicons
const faviconPath = "/assets/dist/img/logo.png";

document.addEventListener("DOMContentLoaded", function () {
    // Standard Favicon
    let favicon = document.querySelector("link[rel='icon']");
    if (!favicon) {
        favicon = document.createElement("link");
        favicon.rel = "icon";
        favicon.type = "image/png";
        document.head.appendChild(favicon);
    }
    favicon.href = faviconPath;

    // Apple Touch Icon
    let appleIcon = document.querySelector("link[rel='apple-touch-icon']");
    if (!appleIcon) {
        appleIcon = document.createElement("link");
        appleIcon.rel = "apple-touch-icon";
        document.head.appendChild(appleIcon);
    }
    appleIcon.href = faviconPath;

    // Shortcut Icon (Older Browsers)
    let shortcutIcon = document.querySelector("link[rel='shortcut icon']");
    if (!shortcutIcon) {
        shortcutIcon = document.createElement("link");
        shortcutIcon.rel = "shortcut icon";
        shortcutIcon.type = "image/png";
        document.head.appendChild(shortcutIcon);
    }
    shortcutIcon.href = faviconPath;
});
