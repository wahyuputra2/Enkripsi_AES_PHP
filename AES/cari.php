<?php

require 'koneksi.php';

if (isset($_POST['input'])) {

    $input = $_POST['input'];

    $query = query("SELECT * FROM file WHERE status = '1' AND  catatan OR nama_file LIKE '%".$input."%'");

    if ($query > 0) { ?>

        <table class="table table-hover" id="dataTable" width="100%" cellspacing="10">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Catatan</th>
                    <th>
                        <center>Dekripsi
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php $i = 1; ?>
                    <?php foreach ($query as $file) : ?>
                        <td><?= $file["nama_file"]; ?></td>
                        <td><?= $file["catatan"]; ?></td>
                        <td><a class="btn btn-info" href="dekripsi_doc.php?id=<?= $file["kode_file"]; ?>" role="button">Dekripsi</a></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>

        <?php
    }
        ?>
            </tbody>
        </table>
    <?php
} else {
    echo "<h6>NO data</h6>";
}

    ?>