export default ({ internalDomain, fallback }) => ({
    back() {
        const referrer = document.referrer;
        const isInternal = referrer.includes(internalDomain);
        const backOverride = sessionStorage.getItem("backOverride");

        if (!backOverride && isInternal && history.length > 1) {
            history.back();
        } else {
            sessionStorage.removeItem("backOverride");
            window.location.href = backOverride || fallback;
        }
    },
});
