import "./bootstrap";
import simpleMde from "./components/simple-mde";

document.addEventListener("alpine:init", () => {
    Alpine.data("simple_mde", simpleMde);
});
