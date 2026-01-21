document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('table');

    tables.forEach(table => {
        const headers = table.querySelectorAll('th');

        headers.forEach((header, index) => {
            // Skip "Action" or "Aksi" columns
            const headerText = header.textContent.trim().toLowerCase();
            if (headerText.includes('action') || headerText.includes('aksi') || header.classList.contains('no-sort')) {
                return; // Do not add click listener
            }

            // Make header look clickable
            header.style.cursor = 'pointer';
            header.title = 'Click to sort';

            // Add sort icon placeholder
            if (!header.querySelector('.sort-icon')) {
                const icon = document.createElement('i');
                icon.className = 'fas fa-sort float-end mt-1 text-muted sort-icon';
                icon.style.fontSize = '0.8em';
                header.appendChild(icon);
            }

            header.addEventListener('click', () => {
                // Determine current sort direction
                const currentDirection = header.getAttribute('data-sort-dir') || 'desc';
                const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

                // Reset other headers
                headers.forEach(h => {
                    if (h !== header) {
                        h.removeAttribute('data-sort-dir');
                        const icon = h.querySelector('.sort-icon');
                        if (icon) {
                            icon.className = 'fas fa-sort float-end mt-1 text-muted sort-icon';
                        }
                    }
                });

                // Set new direction
                header.setAttribute('data-sort-dir', newDirection);

                // Update icon
                const icon = header.querySelector('.sort-icon');
                if (icon) {
                    icon.className = `fas fa-sort-${newDirection === 'asc' ? 'up' : 'down'} float-end mt-1 sort-icon`;
                }

                // Sort the rows
                const tbody = table.querySelector('tbody');
                if (!tbody) return;

                const rows = Array.from(tbody.querySelectorAll('tr'));

                rows.sort((rowA, rowB) => {
                    const cellA = rowA.children[index]?.textContent.trim().toLowerCase() || '';
                    const cellB = rowB.children[index]?.textContent.trim().toLowerCase() || '';

                    // Helper to parse dates
                    const parseDate = (str) => {
                        if (!str || str === '-') return -Infinity; // Treat empty/- as smallest

                        // 1. Try DD/MM/YYYY or DD/MM/YYYY HH:MM
                        const dmyRegex = /^(\d{1,2})\/(\d{1,2})\/(\d{4})(\s+(\d{1,2}):(\d{2}))?$/;
                        const dmyMatch = str.match(dmyRegex);
                        if (dmyMatch) {
                            const [_, day, month, year, time, hour, minute] = dmyMatch;
                            return new Date(year, month - 1, day, hour || 0, minute || 0).getTime();
                        }

                        // 2. Try standard Date.parse (handles "Jan 20, 2026", "20 Jan 2026", etc.)
                        const timestamp = Date.parse(str);
                        if (!isNaN(timestamp)) {
                            return timestamp;
                        }

                        return null;
                    };

                    const dateA = parseDate(cellA);
                    const dateB = parseDate(cellB);

                    // If both are valid dates (conceptually, one might be valid and other -Infinity)
                    // We treat null as "not a date" for fallback to string sort.
                    // But if one is a date and other is empty/- (Infinity), we should sort them as dates.

                    const isDateA = dateA !== null;
                    const isDateB = dateB !== null;

                    if (isDateA && isDateB) {
                        return newDirection === 'asc' ? dateA - dateB : dateB - dateA;
                    }

                    // Check if numeric
                    const numA = parseFloat(cellA.replace(/[^0-9.-]+/g, ''));
                    const numB = parseFloat(cellB.replace(/[^0-9.-]+/g, ''));

                    // Check if strictly numeric string
                    const isNumA = !isNaN(numA) && cellA !== '' && !isDateA;
                    const isNumB = !isNaN(numB) && cellB !== '' && !isDateB;

                    if (isNumA && isNumB) {
                        return newDirection === 'asc' ? numA - numB : numB - numA;
                    }

                    // Fallback to string comparison
                    if (newDirection === 'asc') {
                        return cellA.localeCompare(cellB);
                    } else {
                        return cellB.localeCompare(cellA);
                    }
                });

                // Re-append rows in sorted order
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
});
