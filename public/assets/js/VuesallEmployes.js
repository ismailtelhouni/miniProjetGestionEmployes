function confirmationDelete(fr)
{
    if(confirm("étes-vous sur de vouloir supprimer ce donnée ?")==true)
    {
        fr.action="../employes/{id}";
    }
    else
    {
        fr.action="{{ path('app_employes_index') }}";
    }
}
//{{ path('app_employes_delete', {'id': employe.id}) }}
/*function confirmationEdite(fr)
{
    if(confirm("étes-vous sur de vouloir modifier ce donnée ?")==true)
    {
        fr.action="../controller/Ctrl.class.php?action=UpdateEmployeAction";
    }
    else
    {
        fr.action="../controller/Ctrl.class.php?action=allEmployesAction";
    }
}*/




