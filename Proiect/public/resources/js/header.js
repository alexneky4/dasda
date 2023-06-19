function getHeaderHTMLNotAuthenticated() {
    const headerHTML = `
        <header>
            <nav>
                <div class="logo-wrapper">
                    <a href="../index-page/index.html">EmoF</a>
                </div>
                <div class="actions-wrapper">
                    <a href="../register-page/register.html">Register</a>
                    <a href="../login-page/login.html">Login</a>
                    <a href="../about-page/forgot-password.html">Forgot password</a>
                </div>
            </nav>
        </header>
    `;
    return headerHTML;
}

function getHeaderHTMLAuthenticated() {
    const headerHTML = `
        <header>
            <nav>
                <div class="logo-wrapper">
                    <a href="../index-page/index.html">EmoF</a>
                </div>
                <div class="actions-wrapper">
                    <a href="../register-page/register.html">My account</a>
                    <a href="../login-page/login.html">Logout</a>
                </div>
            </nav>
        </header>
    `;
    return headerHTML;
}

function getPage() {
    const url = window.location.href;
    const page = url.split("/").pop();
    const pageName = page.split(".")[0];
    return pageName;
}

function insertHeader() {
    const pageName = getPage();

    let headerHTML = "";

    switch (pageName) {
        case "login":
        case "index":
        case "register":
        case "about":
            headerHTML = getHeaderHTMLNotAuthenticated();
            break;

        case "home":
            headerHTML = getHeaderHTMLAuthenticated();
            break;
    }

    document.querySelector('body').insertAdjacentHTML('afterbegin', headerHTML);
}

window.addEventListener("load", insertHeader);