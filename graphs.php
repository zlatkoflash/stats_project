<?php include("header.php"); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="span2">
                <!-- Link or button to toggle dropdown -->
                <div class="toggle-state"><a href="#"><b>Choose Chart</b></a></div>
                <ul class="nav nav-list bs-docs-sidenav show-hide-el">
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=le">Λογοι Επισκεψης</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=ee">Επαναληψη Επισκεψης</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=1">Γενικές Εντυπώσεις</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=2">Εγκαταστάσεις</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=3">Προσωπικό</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=4">Θέματα Χρόνου</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=5">Ποιότητα</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=6">Ποιότητα – Δεύτερη επίσκεψη</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=7">Κόστη</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=8">Follow Up</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=9">Στο μέλλον</a></li>
                    <li><i class="icon-chevron-right"></i><a href="graphs.php?chart=10">Κλείσιμο Κλήσης</a></li>
                </ul>
            </div>
            <div class="span10">
                <div class="chart-container">
                    <!-- chart content goes here -->
                    <?php require_once './graphs/graphs_holder.php'; ?>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>
    </div>
</div>
<?php include("footer.php"); ?>