function isObjectEmpty(obj) {
    const isEmpty = Object.keys(obj).length === 0;
    return isEmpty;
}

export { isObjectEmpty as default };
