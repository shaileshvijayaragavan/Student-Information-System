/**
 * Main JavaScript file for Student Information System
 */

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.app-sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && 
            sidebar && 
            sidebar.classList.contains('show') && 
            !sidebar.contains(event.target) && 
            event.target !== sidebarToggle) {
            sidebar.classList.remove('show');
        }
    });
    
    // Initialize datepickers if any
    const datepickers = document.querySelectorAll('.datepicker');
    if (datepickers.length > 0) {
        datepickers.forEach(function(input) {
            // If you want to use a datepicker library, initialize it here
            input.type = 'date'; // Fallback to HTML5 date input
        });
    }
    
    // Handle form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    if (forms.length > 0) {
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }
    
    // Handle confirm dialogs
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    
    if (confirmButtons.length > 0) {
        confirmButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                const message = button.getAttribute('data-confirm') || 'Are you sure you want to perform this action?';
                
                if (!confirm(message)) {
                    event.preventDefault();
                }
            });
        });
    }
    
    // Handle table sorting
    const sortableHeaders = document.querySelectorAll('.sortable');
    
    if (sortableHeaders.length > 0) {
        sortableHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                const table = header.closest('table');
                const thIndex = Array.from(header.parentNode.children).indexOf(header);
                const isAsc = header.classList.contains('asc');
                
                // Clear all sort classes
                table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));
                
                // Set new sort class
                header.classList.add(isAsc ? 'desc' : 'asc');
                
                // Sort the table
                const rows = Array.from(table.querySelectorAll('tbody tr'));
                rows.sort(function(a, b) {
                    const aValue = a.cells[thIndex].textContent.trim();
                    const bValue = b.cells[thIndex].textContent.trim();
                    
                    if (!isNaN(parseFloat(aValue)) && !isNaN(parseFloat(bValue))) {
                        return isAsc ? parseFloat(aValue) - parseFloat(bValue) : parseFloat(bValue) - parseFloat(aValue);
                    } else {
                        return isAsc ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
                    }
                });
                
                // Reorder the table
                const tbody = table.querySelector('tbody');
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    }
    
    // Handle search filtering on tables
    const searchInputs = document.querySelectorAll('.table-search');
    
    if (searchInputs.length > 0) {
        searchInputs.forEach(function(input) {
            input.addEventListener('keyup', function() {
                const tableId = input.getAttribute('data-table');
                const table = document.getElementById(tableId);
                
                if (table) {
                    const rows = table.querySelectorAll('tbody tr');
                    const searchTerm = input.value.toLowerCase();
                    
                    rows.forEach(function(row) {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                }
            });
        });
    }
    
    // Initialize charts if any
    initializeCharts();
});

// Function to initialize charts (if chart.js is included)
function initializeCharts() {
    // Check if Chart.js is available
    if (typeof Chart !== 'undefined') {
        // Attendance Overview Chart
        const attendanceChartElement = document.getElementById('attendanceChart');
        if (attendanceChartElement) {
            new Chart(attendanceChartElement, {
                type: 'pie',
                data: {
                    labels: ['Present', 'Absent', 'Late', 'Excused'],
                    datasets: [{
                        data: [70, 15, 10, 5],
                        backgroundColor: ['#34a853', '#ea4335', '#fbbc04', '#adb5bd']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        // Grade Distribution Chart
        const gradeChartElement = document.getElementById('gradeChart');
        if (gradeChartElement) {
            new Chart(gradeChartElement, {
                type: 'bar',
                data: {
                    labels: ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F'],
                    datasets: [{
                        label: 'Number of Students',
                        data: [10, 20, 25, 15, 12, 8, 5, 3],
                        backgroundColor: '#1a73e8'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
}

// Function for printing a specific element
function printElement(elementId) {
    const element = document.getElementById(elementId);
    
    if (element) {
        const originalContents = document.body.innerHTML;
        const printContents = element.innerHTML;
        
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        
        // Reinitialize scripts after printing
        const script = document.createElement('script');
        script.src = '/assets/js/script.js';
        document.body.appendChild(script);
    }
}

// Function to export table to CSV
function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    
    if (table) {
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = [], cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                // Remove HTML tags and normalize spaces
                let text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, ' ').replace(/\s+/g, ' ').trim();
                // Escape double quotes
                text = text.replace(/"/g, '""');
                // Add double quotes to the cell content
                row.push('"' + text + '"');
            }
            
            csv.push(row.join(','));
        }
        
        downloadCSV(csv.join('\n'), filename);
    }
}

// Function to download CSV
function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], {type: 'text/csv'});
    const downloadLink = document.createElement('a');
    
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}