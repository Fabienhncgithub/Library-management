<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>Books</title>

        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        
        <script src="lib/jquery-validation-1.19.0/jquery.validate.min.js" type="text/javascript"></script>
        <!--<script src='lib/fullcalendar-scheduler-4.1.0/packages/moment/main.js'></script>-->
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/core/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/interaction/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/timeline/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/resource-common/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/resource-timeline/main.js'></script>
        
        <link href='lib/fullcalendar-scheduler-4.1.0/packages/core/main.css' rel='stylesheet' />
        <link href='lib/fullcalendar-scheduler-4.1.0/packages/timeline/main.css' rel='stylesheet' />
        <link href='lib/fullcalendar-scheduler-4.1.0/packages/resource-timeline/main.css' rel='stylesheet' />
        
        <link href="lib/jquery-ui-1.12.1.ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link href="lib/jquery-ui-1.12.1.ui-lightness/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="lib/jquery-ui-1.12.1.ui-lightness/jquery-ui.structure.min.css" rel="stylesheet" type="text/css"/>
        
<!--        <script src='lib/fullcalendar-scheduler-4.1.0/packages/core/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/timeline/main.js'></script>-->
<!--        <script src='lib/fullcalendar-scheduler-4.1.0/packages/resource-common/main.js'></script>
        <script src='lib/fullcalendar-scheduler-4.1.0/packages/resource-timeline/main.js'></script>
        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="lib/jquery-ui-1.12.1.ui-lightness/jquery-ui.min.js" type="text/javascript"></script>-->

    </head>
    <body>
        <script>

//         view = ligne
//         resource = colonne
//         event = rental mettre URL & METHOD
//
//            $('#calendar').focusout(function () {
//                $.get("rental/get_rental", function (data) {
//                    console.log(JSON.parse(data));
//                });
//            });
//            $('#calendar').hide();
//            $.get("rental/get_rental", function (data) {
//                console.log(JSON.parse(data));
//            });

        

            document.addEventListener('DOMContentLoaded', function () {
               $('#btnsearch').hide();
               $('#tab').hide();
                var calendarEl = document.getElementById('calendar');
                $('#calendar').keyup(function () {
                     
                    $.get("rental/get_rental", function (data) {
                        console.log(JSON.parse(data));
                    });
                });

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['interaction', 'resourceTimeline'],
                    timeZone: 'UTC',
                    defaultView: "resourceTimelineWeek",
                    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',

                    header: {
                        left: 'today prev,next',
                        center: 'title',
                        right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear'
                    },
                    defaultView: 'resourceTimelineMonth',
                    scrollTime: '08:00',
                    aspectRatio: 1.5,

                    resourceColumns: [
                        {
                            labelText: 'User',
                            field: 'user'
                        },
                        {
                            labelText: 'Book',
                            field: 'book'
                        }
                    ],
                    views: {
                        year: {
                            slotDuration: {month: 1}
                        },
                        month: {
                            slotDuration: {day: 1},
                            slotLabelFormat: [
                                {day: 'numeric'}
                            ]
                        },
                        week: {
                            slotDuration: {day: 1},
                            slotLabelFormat: [
                                {day: 'numeric'}
                            ]
                        },
                        resourceTimelineDay: {
                            buttonText: ':today',
                            slotDuration: {days: 1}
                        },
                        resourceTimelineTenDay: {
                            type: 'resourceTimeline',
                            duration: {days: 7},
                            buttonText: 'week'
                        }
                    },

                    resources: {
                        url: 'rental/get_rental',
                        method: 'POST',
                        extraParams: function () {
                            return {
                                book: $("#book").val(),
                                member: $("#member").val(),
                                rental_date: $("#rental_date").val(),
                                
                            }
                        }
                    },
                    events: {
                        url: "rental/get_events",
                      method: 'POST',
                        extraParams: function () {
                            return {
                                book: $("#book").val(),
                                member: $("#member").val(),
                                rentaldate: $("#rental_date").val(),
                            }
                        }
                    },

                    eventClick: function (data) {
                        var res = data.event.getResources();
                        var colonne = res["0"]._resource.extendedProps;
                        $("#id").text(data.event.id);
                        $("#user").text(colonne.user);
                        $("#title").text(colonne.book);
                        $("#start").text(data.event.start.toDateString());
                        $("#end").text(colonne.end);
                        $('#confirmDialog').dialog({

                            buttons: {
                                retour: function () {
                                    $.post("Rental/return_date", {retour: data.event.id}, refetch, "html");
                                    $(this).dialog("close");
                                },
                                delete: function () {
                                    $.post("rental/del_rental", {delete: data.event.id}, refetch, "html");
                                    $(this).dialog("close");
                                }
                            }
                        });
                    },
                    editable: true,
//                    resourceLabelText: 'Return',
//                    resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
//                    events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
                });
                calendar.render();
                
                $("#book, #member, #rental_date").on("input", function () {
                    console.log("ehllo");
                    refetch();
                });
                function refetch() {
                    calendar.refetchEvents();
                    calendar.refetchResources();
                }
            });
        </script>
        <div class="title"><?php echo $user->username; ?>!</div>

        <?php
        if ($user->isAdmin($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>

        <div  class="main">
            <form action="rental/filter_return" method="post">
                <input type="hidden" name="search" value="book" id="btnsearch" >
                <table>
                    <thead>
                        <tr>
                            <td>Filters: </td>
                            <td>Member: <input id="member" name="member" type="text" ></td>
                            <td>Book: <input id="book" name="book" type="text"></td>
                            <td>Rental date: <input id="rental_date" name="rentaldate" type="date"></td>
                        </tr>

                    <td>State:
                        <input type="radio" name="MyRadio" value="1" checked>All
                        <input type="radio" name="MyRadio" value="2">Open
                        <input type="radio" name="MyRadio" value="3">Return
                    </td>
                </table>
                
                
                <th><input type="submit" name="search"></th>
                <table id="tab">
                    <tr>
                        <th>Rental Date/Time</th>
                        <th>User</th>
                        <th>Book</th>
                        <th>To be returned on</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($returns as $return): ?>
                            <tr>
                                <td><?= $return->rentaldate ?></td>
                                <td><?= $return->user ?></td>
                                <td><?= $return->book ?></td>
                                <td><?= $return->returndate ?></td>

                                <td>
                                    <?php if (($user->isAdmin($user->username))): ?>
                                        <form  action='rental/delete_rental_return' method='post'>
                                            <input type='hidden' name='deleterental' value='<?= $return->id ?>'>
                                            <input type='submit' value='delete rental'>
                                        </form>
                                    <?php endif; ?>
                                </td>
                                <td>
                                   <?php if (($user->isAdmin($user->username))|| ($user->isManager($user->username))): ?>
                                        <form  action='rental/return_rental' method='post'>
                                            <input type='hidden' name='return' value='<?= $return->id ?>'>
                                            <input type='submit' value='return'>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div id="calendar">
                
                <div id="confirmDialog" hidden>
                    <p hidden>id: <strong id="id"></strong></p>
                    <p>Membre: <strong id="user"></strong></p>
                    <p>Titre: <strong id="title"></strong></p>
                    <p>Date de location: <strong id="start"></strong></p>
                    <p>Date de Retour:<strong id="end"></strong></p>
                </div>
                    
                    </div>
        </div>
    </body>
</html>
