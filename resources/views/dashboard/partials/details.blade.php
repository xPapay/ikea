<div id="details">

</div>

<script>
    $(function() {
        $('#tasks_list').on('click', '.task', function() {
            // alert(this.id);
            $.ajax('/tasks/' + this.id, {
                success: function(data) {

                }
            })
        })
    })
</script>