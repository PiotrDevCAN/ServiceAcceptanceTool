function isAdminSection() {
    var href = window.location.href;
    return href.includes("admin");
}

export { isAdminSection as default };
