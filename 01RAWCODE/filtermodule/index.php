<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    include "get_students.php";
    ?>
    
    <script>
        function sortTableByColumn(tableId, columnIndex) {
            var table = document.getElementById(tableId);
            var rows = Array.from(table.rows).slice(1);

            rows.sort(function (a, b) {
                var cellA = a.cells[columnIndex].innerText.toLowerCase();
                var cellB = b.cells[columnIndex].innerText.toLowerCase();

                if (columnIndex === 0) {
                    cellA = parseInt(cellA) || 0;
                    cellB = parseInt(cellB) || 0;
                }

                if (cellA < cellB) {
                    return -1;
                } else if (cellA > cellB) {
                    return 1;
                } else {
                    return 0;
                }
            });

            table.innerHTML = table.rows[0].outerHTML;

            rows.forEach(function (row) {
                table.appendChild(row);
            });
        }

        function filterTableByStatus(tableId, status) {
            var table = document.getElementById(tableId);
            var rows = Array.from(table.rows).slice(1);

            rows.forEach(function (row) {
                var statusCell = row.cells[2].innerText.toLowerCase();
                if ((status === 'completed' && statusCell.includes('completed')) ||
                    (status === 'notYetTaken' && statusCell.includes('not yet taken'))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>
