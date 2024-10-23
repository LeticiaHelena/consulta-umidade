<!DOCTYPE html>
<html>

<head>
    <title>Consulta Umidade</title>
</head>

<body>
    <form id="dataAlerts" method="POST">
        <div>
            <row>
                <label>Umidade:</label>
                <input type="number" name="umidade"></input>
            </row>
            <row>
                <label>Localização</label>
                <div class="col-6">
                    <label>Latitude:</label>
                    <input type="number" name="lat"></input>
                </div>
                <div class="col-6">
                    <label>Longitude:</label>
                    <input type="number" name="long"></input>
                </div>
            </row>
        </div>
        <button id="btnConsultHumidity" type="submit">Consultar</button>
    </form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('#dataAlerts').click(function(e) {
        e.preventDefault();

        var formData = $(this).serializeArray();

        $.ajax({
            url: '<?= base_url("consultaUmidade/verificaUmidade")?>',
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#resultado').html(response.message);  
                },
                error: function (xhr, status, error) {
                    $('#resultado').html('Erro ao consultar a umidade.');
                }
        });
    });
</script>

</html>