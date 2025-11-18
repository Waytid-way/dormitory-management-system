document.addEventListener('DOMContentLoaded', function() {
    console.log('System Loaded');

    // Highlight active menu based on URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('nav a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href').replace('./', '');
        // Check if current path contains the link href
        if (href !== '../' && currentPath.includes(href)) {
            link.classList.add('active');
            link.style.color = '#3498db';
        }
    });
});

// ฟังก์ชันสำหรับยืนยันการลบ (สามารถเรียกใช้ inline ได้เลย)
function confirmDelete() {
    return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?');
}