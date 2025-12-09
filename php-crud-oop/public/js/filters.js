function filterTable(tableId, inputId, columns) {
    applyAllFilters(tableId);
}

function filterBySelect(tableId, selectId, columnIndex) {
    const select = document.getElementById(selectId);
    const filterValue = select.value.toLowerCase();
    const table = document.getElementById(tableId);
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        if (filterValue === '') {
            rows[i].style.display = '';
        } else {
            const cell = rows[i].getElementsByTagName('td')[columnIndex];
            if (cell) {
                const textValue = cell.textContent || cell.innerText;
                rows[i].style.display = textValue.toLowerCase().indexOf(filterValue) > -1 ? '' : 'none';
            }
        }
    }
    applyAllFilters(tableId);
}

function applyAllFilters(tableId) {
    const table = document.getElementById(tableId);
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    
    // Get all active filters for this table
    let filters = [];
    if (tableId === 'enrollmentTable') {
        const searchFilter = document.getElementById('enrollmentFilter').value.toLowerCase();
        const gradeFilter = document.getElementById('gradeFilter').value.toLowerCase();
        const semesterFilter = document.getElementById('semesterFilter').value.toLowerCase();
        const yearFilter = document.getElementById('schoolYearFilter').value.toLowerCase();
        
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let show = true;
            
            // Apply search filter
            if (searchFilter) {
                let found = false;
                for (let j = 1; j <= 6; j++) {
                    const cell = cells[j];
                    if (cell && cell.textContent.toLowerCase().indexOf(searchFilter) > -1) {
                        found = true;
                        break;
                    }
                }
                if (!found) show = false;
            }
            
            // Apply grade filter
            if (gradeFilter && cells[4]) {
                if (cells[4].textContent.toLowerCase().indexOf(gradeFilter) === -1) {
                    show = false;
                }
            }
            
            // Apply semester filter
            if (semesterFilter && cells[5]) {
                if (cells[5].textContent.toLowerCase().indexOf(semesterFilter) === -1) {
                    show = false;
                }
            }
            
            // Apply school year filter
            if (yearFilter && cells[6]) {
                if (cells[6].textContent.toLowerCase().indexOf(yearFilter) === -1) {
                    show = false;
                }
            }
            
            rows[i].style.display = show ? '' : 'none';
        }
    } else {
        // For other tables, just use the simple filter
        const inputId = tableId.replace('Table', 'Filter');
        const input = document.getElementById(inputId);
        if (input) {
            const filter = input.value.toLowerCase();
            for (let i = 0; i < rows.length; i++) {
                if (filter === '') {
                    rows[i].style.display = '';
                } else {
                    let found = false;
                    const cells = rows[i].getElementsByTagName('td');
                    for (let j = 1; j < cells.length - 1; j++) {
                        if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                    rows[i].style.display = found ? '' : 'none';
                }
            }
        }
    }
}

function clearFilter(tableId, inputId, selectIds = []) {
    document.getElementById(inputId).value = '';
    selectIds.forEach(id => {
        const select = document.getElementById(id);
        if (select) select.value = '';
    });
    
    const table = document.getElementById(tableId);
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = '';
    }
}
