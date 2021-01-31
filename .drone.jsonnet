local Pipeline(version) = {
    kind: "pipeline",
    type: "docker",
    name: "Netscape Bookmark Parser CI - PHP " + version,
    steps: [
        {
            name: "test-php-" + version,
            image: "nodiscc/drone-ci-base:" + version,
            commands: [
                # Install dependencies
                "composer self-update",
                "composer install --prefer-dist",
                # Run linter + tests
                "make lint",
                "make test",
            ]
        }
    ]
};

[
    Pipeline(7.3),
    Pipeline(7.4),
]
