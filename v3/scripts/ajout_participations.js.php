<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">

    let pjs = {<?php foreach ($tout_pjs as $un_pj): ?>
            "<?= $un_pj->id ?>" : "<?= $un_pj->nom ?> <?= $un_pj->prenom ?>",
            <?php endforeach; ?> };

    let pnjs = { <?php foreach ($tout_pnjs as $un_pnj): ?>
                        "<?= $un_pnj->id ?>" : "<?= $un_pnj->nom ?> <?= $un_pnj->prenom ?>",
                        <?php endforeach; ?> };

    $(document).ready(function() {

        // EVENT LISTENER pour le bouton Ajouter un PJ
        $("#add-participants").click(function(e)
        {
            e.preventDefault();
            let numberOfparticipants = $("#form1").find("select[name^='participants']").length;

            let new_select_pj = '<select class="form-control mt-1 col-8" name="participants[' + numberOfparticipants + ']" required id="data[participants][' + numberOfparticipants + ']" >';
            for (key in pjs) new_select_pj += '<option value="' + key + '">' + pjs[key] + '</option>';
            new_select_pj += '</select>';
            let xp = '<input class="form-control ml-1 mt-1 col-2" type="number" name="participants_xp[' + numberOfparticipants + ']" value="0" id="data[participants_xp][' + numberOfparticipants + ']" />';
            let mort = '<input class="mt-1 ml-1 col-1" type="checkbox" name="participants_mort[' + numberOfparticipants + ']" id="data[participants_mort][' + numberOfparticipants + ']" />';
            let html = '<div class="participants form-row">' + new_select_pj + xp + mort + '</div>';
            $("#form1").find("#add-participants").before(html);

            let removePJButton = '<button class="remove-participants btn mt-2 ml-2">Retirer</button>';
            if (numberOfparticipants == 0)
                $("#form1").find("#add-participants").after(removePJButton);
        });

        // EVENT LISTENER pour le bouton Ajouter un PNJ
        $("#add-participants_pnjs").click(function(e)
        {
            e.preventDefault();
            let numberOfparticipants_pnjs = $("#form1").find("select[name^='participants_pnjs']").length;

            let new_select_pnj = '<select class="form-control mt-1 col-10" name="participants_pnjs[' + numberOfparticipants_pnjs + ']" required id="data[participants_pnjs][' + numberOfparticipants_pnjs + ']" >';
            for (cle in pnjs) new_select_pnj += '<option value="' + cle + '">' + pnjs[cle] + '</option>';
            new_select_pnj += '</select>';
            let mort_pnj = '<input class="mt-1 ml-1 col-1" type="checkbox" name="participants_pnjs_mort[' + numberOfparticipants_pnjs + ']" id="data[participants_pnjs_mort][' + numberOfparticipants_pnjs + ']" />';
            var html = "<div class='participants_pnjs form-row'>" + new_select_pnj + mort_pnj + "</div>";
            $("#form1").find("#add-participants_pnjs").before(html);

            let removePNJButton = '<button class="remove-participants_pnjs btn mt-2 ml-2">Retirer</button>';
            if (numberOfparticipants_pnjs == 0)
                $("#form1").find("#add-participants_pnjs").after(removePNJButton);
        });

    });

    // EVENT LISTENER pour le bouton Supprimer un PJ
    $(document).on("click", ".remove-participants",function(e){
        e.preventDefault();
        $('#form1 div.participants:last').remove();

        let numberOfparticipants = $("#form1").find("select[name^='participants']").length;
        if (numberOfparticipants == 0)
            $('#form1 button.remove-participants').remove();
    });

    // EVENT LISTENER pour le bouton Supprimer un PNJ
    $(document).on("click", ".remove-participants_pnjs",function(e){
        e.preventDefault();
        $('#form1 div.participants_pnjs:last').remove();

        let numberOfparticipants_pnjs = $("#form1").find("select[name^='participants_pnjs']").length;
        if (numberOfparticipants_pnjs == 0)
            $('#form1 button.remove-participants_pnjs').remove();
    });
    
</script>