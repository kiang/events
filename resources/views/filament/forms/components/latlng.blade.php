<div>
    <input type="text" value="" id="latlngHelper" />
</div>
<script>
    document.querySelector('#latlngHelper').addEventListener('change', function () {
        let latlng = document.querySelector('#latlngHelper').value.split(',');
        if (latlng[1]) {
            @this.set('data.latitude', parseFloat(latlng[0]));
            @this.set('data.longitude', parseFloat(latlng[1]));
        }
    });
</script>