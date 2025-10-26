export default (options = {}, initValues = {}) => ({
    simpleMde: null,
    content: initValues.content,
    init() {
        this.simpleMde = new SimpleMDE({
            ...options,
            initialValue: this.content,
        });
        this.simpleMde.codemirror.on("change", () => {
            this.$refs.textarea.value = this.simpleMde.value();
            this.$refs.textarea.dispatchEvent(new Event("input"));
        });
        this.simpleMde.codemirror.on("blur", () => {
            this.$refs.textarea.value = this.simpleMde.value();
            this.$refs.textarea.dispatchEvent(new Event("change"));
        });
        // this.$watch("content", (value) => {
        //     console.log("content changed", value);
        // });
    },
});
