<?php

namespace App\Providers;

use App\Contracts\AccessConfigurationInterface;
use App\Contracts\AccountInterface;
use App\Contracts\AreaInterface;
use App\Contracts\BankInterface;
use App\Contracts\ContactInterface;
use App\Contracts\EncryptInterface;
use App\Contracts\GlobalPassbookInterface;
use App\Contracts\InquiryInterface;
use App\Contracts\InvoiceInterface;
use App\Contracts\LimitInterface;
use App\Contracts\LocationInterface;
use App\Contracts\LogLoginInterface;
use App\Contracts\NotificationInterface;
use App\Contracts\OTPInterface;
use App\Contracts\ParentAccountInterface;
use App\Contracts\PassbookInterface;
use App\Contracts\PicInterface;
use App\Contracts\PositionInterface;
use App\Contracts\ProfileInterface;
use App\Contracts\RegistrationInterface;
use App\Contracts\RemittanceInterface;
use App\Contracts\TokenInterface;
use App\Contracts\UserInterface;
use App\Contracts\MemberInterface;
use App\Contracts\MerchantInterface;
use App\Contracts\ProductInterface;
use App\Contracts\ServiceInterface;
use App\Contracts\TerminalInterface;
use App\Contracts\RoleInterface;
use App\Contracts\CityInterface;
use App\Services\AccessConfigurationRepository;
use App\Services\AccountRepository;
use App\Services\AreaRepository;
use App\Services\BankRepository;
use App\Services\CityRepository;
use App\Services\ContactRepository;
use App\Services\EncryptRepository;
use App\Services\GlobalPassbookRepository;
use App\Services\InquiryRepository;
use App\Services\InvoiceRepository;
use App\Services\LimitRepository;
use App\Services\LocationRepository;
use App\Services\LogLoginRepository;
use App\Services\MemberRepository;
use App\Services\NotificationRepository;
use App\Services\OTPRepository;
use App\Services\ParentAccountRepository;
use App\Services\PassbookRepository;
use App\Services\PicRepository;
use App\Services\PositionRepository;
use App\Services\ProfileRepository;
use App\Services\RegistrationRepository;
use App\Services\RemittanceRepository;
use App\Services\RoleRepository;
use App\Services\StateRepository;
use App\Contracts\StateInterface;
use App\Services\CompanyRepository;
use App\Services\CountryRepository;
use App\Contracts\CountryInterface;
use App\Services\ServiceRepository;
use App\Contracts\CompanyInterface;
use App\Services\ProductRepository;
use App\Services\MerchantRepository;
use App\Services\IndustryRepository;
use App\Services\IdentityRepository;
use App\Contracts\IdentityInterface;
use App\Contracts\IndustryInterface;
use App\Services\TerminalRepository;
use App\Contracts\TransactionInterface;
use App\Services\TokenRepository;
use App\Services\TransactionRepository;
use App\Services\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\PartnershipRepository;
use App\Contracts\PartnershipInterface;
use App\Services\AdministratorRepository;
use App\Contracts\AdministratorInterface;


/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegistrationInterface::class, RegistrationRepository::class);

        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(MemberInterface::class, MemberRepository::class);
        $this->app->bind(MerchantInterface::class, MerchantRepository::class);
        $this->app->bind(CountryInterface::class, CountryRepository::class);
        $this->app->bind(StateInterface::class, StateRepository::class);
        $this->app->bind(CityInterface::class, CityRepository::class);
        $this->app->bind(IndustryInterface::class, IndustryRepository::class);
        $this->app->bind(IdentityInterface::class, IdentityRepository::class);
        $this->app->bind(PartnershipInterface::class, PartnershipRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(AdministratorInterface::class, AdministratorRepository::class);
        $this->app->bind(ServiceInterface::class, ServiceRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(TerminalInterface::class, TerminalRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(InvoiceInterface::class, InvoiceRepository::class);
        $this->app->bind(InquiryInterface::class, InquiryRepository::class);
        $this->app->bind(LimitInterface::class, LimitRepository::class);
        $this->app->bind(AccountInterface::class, AccountRepository::class);

        $this->app->bind(ContactInterface::class, ContactRepository::class);
        $this->app->bind(LocationInterface::class, LocationRepository::class);
        $this->app->bind(BankInterface::class, BankRepository::class);
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);

        $this->app->bind(TokenInterface::class, TokenRepository::class);
        $this->app->bind(PassbookInterface::class, PassbookRepository::class);
        $this->app->bind(GlobalPassbookInterface::class, GlobalPassbookRepository::class);

        $this->app->bind(PositionInterface::class, PositionRepository::class);
        $this->app->bind(PicInterface::class, PicRepository::class);
        $this->app->bind(OTPInterface::class, OTPRepository::class);

        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(LogLoginInterface::class, LogLoginRepository::class);
        $this->app->bind(ParentAccountInterface::class, ParentAccountRepository::class);
        $this->app->bind(AccessConfigurationInterface::class, AccessConfigurationRepository::class);

        $this->app->bind(AreaInterface::class, AreaRepository::class);
        $this->app->bind(EncryptInterface::class, EncryptRepository::class);
        $this->app->bind(RemittanceInterface::class, RemittanceRepository::class);
    }
}
