import "./bootstrap";
import simpleMde from "./components/simple-mde";
import backButton from "./components/back-button";

document.addEventListener("alpine:init", () => {
    Alpine.data("simple_mde", simpleMde);
    Alpine.data("back_button", backButton);
});
