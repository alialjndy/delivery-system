<?php
namespace src\UserContext\Domain\Entities;

use src\Shared\Domain\Events\UserRegisterd;
use src\UserContext\Domain\Exceptions\UserAlreadyHaveRoleException;
use src\UserContext\Domain\ValueObjects\Email;
use src\UserContext\Domain\ValueObjects\Password;
use src\UserContext\Domain\ValueObjects\Role;

class User{
    // private Role $role = Role::CUSTOMER;
    private $domainEvents = [];
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private Email $email,
        private ?Password $password = null,
        private ?string $provider = null,
        private ?string $email_verified_at = null,
        private Role $role = Role::CUSTOMER,

    ){}
    public static function register(string $name, Email $email, Password $password): self{
        $user = new self(null, $name, $email, $password);

        // Assign default role
        $user->assignDefaultRole(Role::CUSTOMER);

        // Add Event for User Registration (I need it to create wallet to the user dynamically)
        // $user->domainEvents[] = new UserRegisterd($user->getId());

        return $user;
    }
    public static function registerWithProvider(string $name, Email $email, string $provider): self{
        $user = new self(null, $name, $email, null, $provider);

        $user->assignDefaultRole(Role::CUSTOMER);

        // Mark email as verified for social login users
        $user->markEmailAsVerified();

        // $user->domainEvents[] = new UserRegisterd($user->getId());
        return $user;
    }
    public function addEvent(object $event): void{$this->domainEvents[] = $event;}
    public static function reconstitute(array $data): self{
        return new self(
            $data['id'],
            $data['name'],
            new Email($data['email']),
            isset($data['password']) ? new Password($data['password'], true) : null,
            $data['provider'] ?? null,
            $data['email_verified_at'] ?? null,
            Role::from($data['role']),
        );
    }
    public function markEmailAsVerified(): void{$this->email_verified_at = date('Y-m-d H:i:s');}
    public function assignDefaultRole(Role $role): void{$this->role = $role;}
    public function pullEvents(): array{
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    public function assignRole(Role $role){

        // Prevent assigning the same role
        if($this->role === $role){
            throw new UserAlreadyHaveRoleException();
        }
        $this->role = $role;
    }



    // Getters
    public function getId(): ?int{return $this->id;}
    public function getName(): string{return $this->name;}
    public function getEmail(): string{return $this->email->getEmail();}
    public function getPassword(){return $this->password;}
    public function getProvider(): ?string{return $this->provider;}
    public function getEmailVerifiedAt(): ?string { return $this->email_verified_at; }
    public function getRole(): Role {return $this->role ;}

}
