<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
</head>

<body>
    <h1>Client Notifications</h1>

    <?php if(!empty($clientActions)): ?>
        <ul>
            <?php foreach($clientActions as $action): ?>
                <li>
                    <?= $action['action']; ?> -
                    <?= $action['created_at']; ?>
                    <?php if($action['action'] === 'buy' && isset($action['product_name'])): ?>
                        (Bought
                        <?= $action['product_name']; ?>)
                    <?php elseif($action['action'] === 'delete'): ?>
                        (Canceled
                        <?= $action['order_id']; ?>)
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No recent changes.</p>
    <?php endif; ?>

</body>

</html>