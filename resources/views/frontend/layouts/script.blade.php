 <!-- Scripts -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="{{ asset('front_theme/assets/js/main.js')}}"></script>

 <script>
    // Generate avatar with first letter
    function generateAvatar(element, companyName) {
        if (!companyName || companyName.trim() === '') {
            companyName = '?';
        }

        // Get first letter and convert to uppercase
        const firstLetter = companyName.trim().charAt(0).toUpperCase();

        // Generate a color based on the letter (consistent color for same letter)
        const colors = [
            '#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8',
            '#6f42c1', '#e83e8c', '#fd7e14', '#20c997', '#6610f2'
        ];
        const colorIndex = firstLetter.charCodeAt(0) % colors.length;
        const bgColor = colors[colorIndex];

        // Create canvas to generate avatar
        const canvas = document.createElement('canvas');
        canvas.width = 40;
        canvas.height = 40;
        const ctx = canvas.getContext('2d');

        // Draw background circle
        ctx.fillStyle = bgColor;
        ctx.beginPath();
        ctx.arc(20, 20, 20, 0, 2 * Math.PI);
        ctx.fill();

        // Draw text
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 18px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(firstLetter, 20, 20);

        // Convert canvas to image
        const img = document.createElement('img');
        img.src = canvas.toDataURL();
        img.className = 'rounded bg-light';
        img.style.width = '40px';
        img.style.height = '40px';
        img.style.objectFit = 'cover';
        img.alt = companyName;

        // Replace the placeholder div with the generated image
        element.innerHTML = '';
        element.appendChild(img);
    }

    // Initialize avatars when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Find all avatar placeholders
        const avatarPlaceholders = document.querySelectorAll('.company-avatar-placeholder');

        avatarPlaceholders.forEach(function(placeholder) {
            const companyName = placeholder.getAttribute('data-company');
            generateAvatar(placeholder, companyName);
        });

        // Also handle images that fail to load
        const jobLogos = document.querySelectorAll('.job-logo-img');
        jobLogos.forEach(function(img) {
            img.addEventListener('error', function() {
                const placeholder = this.closest('.job-logo-container');
                if (placeholder) {
                    const companyName = placeholder.getAttribute('data-company');
                    const avatarDiv = document.createElement('div');
                    avatarDiv.className = 'company-avatar-placeholder d-flex align-items-center justify-content-center rounded';
                    avatarDiv.setAttribute('data-company', companyName || '');
                    avatarDiv.style.width = '40px';
                    avatarDiv.style.height = '40px';
                    this.style.display = 'none';
                    generateAvatar(avatarDiv, companyName);
                    placeholder.appendChild(avatarDiv);
                }
            });
        });
    });
 </script>

  @yield('scripts')
