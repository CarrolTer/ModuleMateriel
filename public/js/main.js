$(document).ready(function() {
   let table = $('#data_table').DataTable( {
        'columnDefs' : [
            {
                'searchable'    : false,
                'targets'       : [1,2,3,4]
            },
        ],
        "dom": '<"pull-left"f><"pull-right"l>tip',
        'language': {
            searchPlaceholder: "Nom du produit",
            search: "Rechercher un produit",
        },
    })
} );