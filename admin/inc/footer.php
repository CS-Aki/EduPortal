<script>
function toggleSidebar() {
    const sidebar = document.getElementById('mobile_directory');
    sidebar.classList.toggle('active_directory');

    const body = document.body;
    body.classList.toggle('overflow-hidden');
}
</script>