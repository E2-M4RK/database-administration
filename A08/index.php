<?php
include("connect.php");

$departureFilter = $_GET['departureAirportCode'] ?? '';
$arrivalFilter = $_GET['arrivalAirportCode'] ?? '';
$airlineFilter = $_GET['airlineName'] ?? '';
$sort = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? '';

$flightLogsQuery = "SELECT * FROM flightLogs";

if ($departureFilter != '' || $arrivalFilter != '' || $airlineFilter != '') {
    $flightLogsQuery = $flightLogsQuery . " WHERE";

    if ($departureFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " departureAirportCode='$departureFilter'";
    }

    if ($departureFilter != '' && ($arrivalFilter != '' || $airlineFilter != '')) {
        $flightLogsQuery = $flightLogsQuery . " AND";
    }

    if ($arrivalFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " arrivalAirportCode='$arrivalFilter'";
    }

    if ($arrivalFilter != '' && $airlineFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " AND";
    }

    if ($airlineFilter != '') {
        $flightLogsQuery = $flightLogsQuery . " airlineName='$airlineFilter'";
    }
}

if ($sort != '') {
    $flightLogsQuery = $flightLogsQuery . " ORDER BY $sort";

    if ($order != '') {
        $flightLogsQuery = $flightLogsQuery . " $order";
    }
}

$flightLogsResults = executeQuery($flightLogsQuery);

$departureQuery = "SELECT DISTINCT(departureAirportCode) FROM flightLogs";
$departureResults = executeQuery($departureQuery);

$arrivalQuery = "SELECT DISTINCT(arrivalAirportCode) FROM flightLogs";
$arrivalResults = executeQuery($arrivalQuery);

$airlineQuery = "SELECT DISTINCT(airlineName) FROM flightLogs";
$airlineResults = executeQuery($airlineQuery);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flight Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container my-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">PUP AIRPORT LOG</h2>
        </div>
    </div>

    <div class="row mb-4">     
        <div class="col text-end">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterMenu" aria-expanded="false" aria-controls="filterMenu">
                Filter
            </button>
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#sortMenu" aria-expanded="false" aria-controls="sortMenu">
                Sort
            </button>
            <form method="get" action="" class="d-inline-block">
            <button class="btn btn-warning" type="submit">
                Reset
            </button>
            </form>
        </div>
    </div>

    <div class="collapse mb-4" id="filterMenu">
        <div class="card card-body">
            <form method="GET" action="">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label for="departureSelect" class="form-label">Departure</label>
                        <select id="departureSelect" name="departureAirportCode" class="form-select">
                            <option value="">Any</option>
                            <?php
                           if (mysqli_num_rows($departureResults) > 0) {
                            while ($row = mysqli_fetch_assoc($departureResults)) {
                                ?>
                                <option value="<?= $row['departureAirportCode'] ?>" <?= $departureFilter == $row['departureAirportCode'] ? 'selected' : '' ?>>
                                    <?= $row['departureAirportCode'] ?>
                                </option>
                                <?php
                            }
                        }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="arrivalSelect" class="form-label">Arrival</label>
                        <select id="arrivalSelect" name="arrivalAirportCode" class="form-select">
                            <option value="">Any</option>
                            <?php
                            if (mysqli_num_rows($arrivalResults) > 0) {
                                while ($arrivalRow = mysqli_fetch_assoc($arrivalResults)) {
                                    ?>
                                    <option <?php if ($arrivalFilter == $arrivalRow['arrivalAirportCode']) { echo "selected"; } ?>
                                        value="<?php echo $arrivalRow['arrivalAirportCode'] ?>">
                                        <?php echo $arrivalRow['arrivalAirportCode'] ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="airlineSelect" class="form-label">Airline</label>
                        <select id="airlineSelect" name="airlineName" class="form-select">
                            <option value="">Any</option>
                            <?php
                            if (mysqli_num_rows($airlineResults) > 0) {
                                while ($airlineRow = mysqli_fetch_assoc($airlineResults)) {
                                    ?>
                                    <option <?php if ($airlineFilter == $airlineRow['airlineName']) { echo "selected"; } ?>
                                        value="<?php echo $airlineRow['airlineName'] ?>">
                                        <?php echo $airlineRow['airlineName'] ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary mt-4" type="submit">Apply Filters</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="collapse mb-4" id="sortMenu">
        <div class="card card-body">
            <form method="GET" action="">
                <input type="hidden" name="departureAirportCode" value="<?php echo $departureFilter; ?>">
                <input type="hidden" name="arrivalAirportCode" value="<?php echo $arrivalFilter; ?>">
                <input type="hidden" name="airlineName" value="<?php echo $airlineFilter; ?>">

                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <label for="sort" class="form-label">Sort By</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="">None</option>
                            <option <?php if ($sort == "flightNumber") { echo "selected"; } ?> value="flightNumber">Flight Number</option>
                            <option <?php if ($sort == "departureDatetime") { echo "selected"; } ?> value="departureDatetime">Departure Time</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="order" class="form-label">Order</label>
                        <select id="order" name="order" class="form-select">
                            <option <?php if ($order == "ASC") { echo "selected"; } ?> value="ASC">Ascending</option>
                            <option <?php if ($order == "DESC") { echo "selected"; } ?> value="DESC">Descending</option>
                        </select>
                    </div>

                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary mt-4" type="submit">Apply Sort</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card p-4 rounded-5">
    <table class="table table-dark table-hover table-bordered text-center align-middle">
        <thead>
            <tr class="table-warning">
                <th scope="col">Flight Number</th>
                <th scope="col">Departure</th>
                <th scope="col">Arrival</th>
                <th scope="col">Airline</th>
                <th scope="col">Departure Time</th>
                <th scope="col">Arrival Time</th>
                <th scope="col">Duration (min)</th>
                <th scope="col">Passenger Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($flightLogsResults) > 0) {
                while ($flightRow = mysqli_fetch_assoc($flightLogsResults)) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $flightRow['flightNumber']; ?></th>
                        <td><?php echo $flightRow['departureAirportCode']; ?></td>
                        <td><?php echo $flightRow['arrivalAirportCode']; ?></td>
                        <td><?php echo $flightRow['airlineName']; ?></td>
                        <td><?php echo $flightRow['departureDatetime']; ?></td>
                        <td><?php echo $flightRow['arrivalDatetime']; ?></td>
                        <td><?php echo $flightRow['flightDurationMinutes']; ?></td>
                        <td><?php echo $flightRow['passengerCount']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
