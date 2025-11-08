export default ({ highlightClass, duration }) => ({
    highlight() {
        console.log("highlight");
        const commentId = this.$event.detail[0].commentId;
        this.$nextTick(() => {
            const el = document.querySelector(`#comment-${commentId}`);
            if (el) {
                el.scrollIntoView({ behavior: "smooth", block: "center" });
                el.classList.add(highlightClass); // highlight

                setTimeout(() => el.classList.remove(highlightClass), duration);
            }
        });
    },
});
