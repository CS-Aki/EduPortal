<script>
function toggleSidebar() {
    const sidebar = document.getElementById('mobile_directory');
    sidebar.classList.toggle('active_directory');

    const body = document.body;
    body.classList.toggle('overflow-hidden');
}
    console.log("toggle");

document.addEventListener("click", function(event) {
    if (event.altKey) {
        let target = event.target.closest("a, button");
        if (target) {
            event.preventDefault();
        }
    }
});

</script>