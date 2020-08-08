<?php
require_once dirname(__FILE__) . '/../../definitions.php';

function anfragen_table($row)
{
    switch ($row['status']) {
        case "Offen":
            $row['status'] = '<span style="color: red;">' . $row['status'] . '</span>';
            break;
        case "Ausstehend":
            $row['status'] = '<span style="color: orange;">' . $row['status'] . '</span>';
            break;
        case "Abgelehnt":
            $row['status'] = '<span style="color: purple;">' . $row['status'] . '</span>';
            break;
        case "Beauftragt":
            $row['status'] = '<span style="color: green;">' . $row['status'] . '</span>';
            break;
    }

    return '<tr>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $row['kunden_name'] . '</span></td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $row['plz_start'] . '</td>
    <td>' . $row['plz_ziel'] . '</td>
    <td>' . $row['status'] . '</td>
    <td>
        <img src="../images/an_auf_table/eye.png" style="width: 22px; height: 14px; cursor: pointer;">
        <img src="../images/an_auf_table/change_status.png" style="width: 18px; height: 18px; cursor: pointer;">
    </td>
</tr>';
}

function auftraege_table($row)
{
    return '<tr>
    <td>
    <span>&nbsp;<img src="../images/an_auf_table/firmen_details.png">&nbsp;' . $row['kunden_name'] . '</span></td>
    <td>' . date_format(date_create($row['zeit']), "d/m/Y") . '</td>
    <td>' . $row['plz_start'] . '</td>
    <td>' . $row['plz_ziel'] . '</td>
    <td>' . $row['completed'] . '</td>
    <td>
        <img src="../images/an_auf_table/eye.png">
        <img src="../images/an_auf_table/change_status.png">
    </td>
</tr>';
}
