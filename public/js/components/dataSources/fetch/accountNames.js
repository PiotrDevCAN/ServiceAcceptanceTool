// fetch request
const accountNames = fetch(window.apiUrl + "account/list").then((response) => response.json());

export default await accountNames;
