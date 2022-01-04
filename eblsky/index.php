    <?php $orderID = "EBLSPD".time(); ?>
    <form action="http://plil.pragatilife.com/p_pay/eblsky/process.php" method="post">
        <input type="text" name="order[amount]" value="" size="8" maxlength="13" required /> 
        <input type="hidden" name="order[id]" value="<?php echo $orderID;?>">
        <input type="hidden" name="order[description]" value="PLIL Payment Gateway">
        <input type="hidden" name="order[currency]" value="BDT">
        <input type="hidden" name="interaction[cancelUrl]" value="http://plil.pragatilife.com/p_pay/eblsky/cancel.php?order=<?php echo $orderID;?>">
        <input type="hidden" name="interaction[returnUrl]" value="http://plil.pragatilife.com/p_pay/eblsky/complete.php?order=<?php echo $orderID;?>">
        <input type="hidden" name="interaction[merchant][name]" value="PLIL Payment Gateway">
        <input type="hidden" name="interaction[merchant][logo]" value="https://plil.pragatilife.com/p_pay/asset/images/logo_sk.jpg">
        <input type="hidden" name="interaction[displayControl][billingAddress]" value="HIDE">
        <input type="hidden" name="interaction[displayControl][orderSummary]" value="HIDE">
        <input type="submit" name="submit" value="PAY WITH EBL SKYPAY"/>
    </form>
