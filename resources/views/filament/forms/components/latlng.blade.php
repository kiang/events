<div>
    <input type="text" value="" id="latlngHelper" />
</div>
<script>
    document.querySelector('#latlngHelper').addEventListener('change', function() {
        let latlng = document.querySelector('#latlngHelper').value.split(',');
        if(latlng[1]) {
            document.querySelector('#data\\.latitude').value = parseFloat(latlng[0]);
            document.querySelector('#data\\.longitude').value = parseFloat(latlng[1]);
        }
    });
</script>