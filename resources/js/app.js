import "./bootstrap";
import simpleMde from "./components/simple-mde";
import backButton from "./components/back-button";
import commentSection from "./components/comment-section";

document.addEventListener("alpine:init", () => {
    Alpine.data("simple_mde", simpleMde);
    Alpine.data("back_button", backButton);
    Alpine.data("comment_section", commentSection);
});
