<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap.min.css') ?>">
</head>

<body>
    <div class="container-xxl">
        <div class="row">
            <div class="col-md-12 mt-3">
                <h1 style="text-align: center;">
                    <?= $title ?>
                </h1>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="text-uppercase text-white" style="background: #441313;">
                            <tr>
                                <th>id</th>
                                <th>longitude</th>
                                <th>latitude</th>
                                <th>voltage</th>
                                <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_monitoring as $key => $value) { ?>
                                <tr style="text-align: center; height:1cm">
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['longitude'] ?></td>
                                    <td><?= $value['latitude'] ?></td>
                                    <td><?= $value['voltage'] ?></td>
                                    <td><?= substr($value['created_at'], 0, 8) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    // == aktifkan script dibawah ini untuk auto refresh page tiap 10 detik
    setTimeout(function() {
        window.location.reload(1);
    }, 10000); // satuan ms
</script>