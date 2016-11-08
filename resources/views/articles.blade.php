<!DOCTYPE html>
<html>
<head>
	<title>Articles</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" >

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h3>Articles</h3>
    	<table class="table table-striped table-hover">
        <thead>
            <tr>
                <td>ID</td>
                <td>Title</td>
                <td></td>
            </tr>
        </thead>
        <tbody class="sortable" data-entityname="articles">
        @foreach (\App\Article::sorted()->get() as $article)
        <tr data-itemId="{{{ $article->id }}}">
            <td class="id-column">{{{ $article->id }}}</td>
            <td>{{{ $article->title }}}</td>
            <td class="sortable-handle"><span class="glyphicon glyphicon-sort"></span></td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</body>

<script>
    /**
     *
     * @param type string 'insertAfter' or 'insertBefore'
     * @param entityName
     * @param id
     * @param positionId
     */
    var changePosition = function(requestData){
        $.ajax({
            'url': '/sort',
            'type': 'POST',
            'data': requestData,
            'success': function(data) {
                if (data.success) {
                    console.log('Saved!');
                } else {
                    console.error(data.errors);
                }
            },
            'error': function(data){
                console.error('Something wrong!');
            }
        });
    };

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var $sortableTable = $('.sortable');
        if ($sortableTable.length > 0) {
            $sortableTable.sortable({
                handle: '.sortable-handle',
                axis: 'y',
                update: function(a, b){

                    var entityName = $(this).data('entityname');
                    var $sorted = b.item;

                    var $previous = $sorted.prev();
                    var $next = $sorted.next();

                    if ($previous.length > 0) {
                        changePosition({
                            parentId: $sorted.data('parentid'),
                            type: 'moveAfter',
                            entityName: entityName,
                            id: $sorted.data('itemid'),
                            positionEntityId: $previous.data('itemid')
                        });
                    } else if ($next.length > 0) {
                        changePosition({
                            parentId: $sorted.data('parentid'),
                            type: 'moveBefore',
                            entityName: entityName,
                            id: $sorted.data('itemid'),
                            positionEntityId: $next.data('itemid')
                        });
                    } else {
                        console.error('Something wrong!');
                    }
                },
                cursor: "move"
            });
        }
    });
</script>

</html>