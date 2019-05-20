<?php
 
namespace WunschgutscheinPayment\Helper;
 
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;
 
/**
 * Class WunschgutscheinPaymentHelper
 *
 * @package WunschgutscheinPayment\Helper
 */
class WunschgutscheinPaymentHelper
{
    /**
     * @var PaymentMethodRepositoryContract $paymentMethodRepository
     */
    private $paymentMethodRepository;
 
    /**
     * WunschgutscheinPaymentHelper constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }
 
    /**
     * Create the ID of the payment method if it doesn't exist yet
     */
    public function createMopIfNotExists()
    {

        if($this->getPaymentMethod() == 'no_paymentmethod_found')
        {
            $paymentMethodData = array( 'pluginKey' => 'plenty_WunschgutscheinPayment',
                                        'paymentKey' => 'WunschgutscheinPayment',
                                        'name' => 'Wunschgutschein');
 
            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
    }
 
    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getPaymentMethod()
    {
        $paymentMethods = $this->paymentMethodRepository->allForPlugin('plenty_WunschgutscheinPayment');
 
        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == 'WunschgutscheinPayment')
                {
                    return $paymentMethod->id;
                }
            }
        }
 
        return 'no_paymentmethod_found';
    }
}
