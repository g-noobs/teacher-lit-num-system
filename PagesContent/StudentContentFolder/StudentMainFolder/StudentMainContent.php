<div class="container">
    <!-- <h2>Dynamic Tabs</h2>
    <p>To make the tabs toggleable, add the response-toggle="tab" attribute to each link. Then add a .tab-pane class with a
        unique ID for every tab and wrap them inside a div element with class .tab-content.</p> -->

    <ul class="nav nav-tabs" id="dynamic-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    </ul>

    <div class="tab-content" id="dynamic-content">
        <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.</p>
        </div>
    </div>
</div>

<script>
$(function() {
    $.ajax({
        url: '../PagesContent/StudentContentFolder/ActionStudent/ActionGetClassData.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Populate dynamic tabs
            var tabsContainer = $('#dynamic-tabs');
            var contentContainer = $('#dynamic-content');
            $.each(response, function(index, tab) {
                var tabId = 'tab' + tab.id;
                var tabContent = '<div id="' + tabId + '" class="tab-pane fade"></div>';

                tabsContainer.append('<li><a data-toggle="tab" href="#' + tabId + '">' + tab
                    .name +
                    '</a></li>');
                contentContainer.append(tabContent);

                tabs += '<li class="' + active + '"><a href="#' + item.class_id +
                    '" data-toggle="tab">' + item.class_name + '</a></li>';

                content += '<div class="tab-pane ' + active + '" id="' + item.class_id +
                    '">' + item
                    .class_name + '</div>';
                active = "";
            });
            $('#dynamic-tabs').append(tabs);
            $('#dynamic-content').append(content);
        },
    });
});
</script>