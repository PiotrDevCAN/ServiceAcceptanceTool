function showHideSpinner(action) {
    switch(action) {
        case "show":
            //show the loading spinner ++++
            document.getElementById('spinner').className = "loading";
            document.getElementById('spinner').innerHTML = "Loading&#8230;";
            break;
        case "hide":
            //remove the spinner
            document.getElementById('spinner').className = "";
            document.getElementById('spinner').innerHTML = "";
            break;
        default:
            break;
    }

}

export { showHideSpinner as default };
