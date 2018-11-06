class AuthorizationClass extends Authorization
{
    public function getRoles() {
        return [
            'admin' => [
                    'update-post',
                ],
            'manager' => [
                    'update-post-in-category',
                ],
            'user' => [
                    'update-own-post',
                    'add-to-favorites',
                ],
        ];
    }
}