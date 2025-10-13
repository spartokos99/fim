# Basis-Image mit PHP 8.3
FROM php:8.3-fpm

# Argument für Nicht-Root-Benutzer
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# Erstelle Nicht-Root-Benutzer für VS Code
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME \
    && apt-get update \
    && apt-get install -y sudo \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

# Installiere System-Abhängigkeiten
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Installiere PHP-Extensionen
RUN docker-php-ext-install \
    pcntl \
    intl \
    mbstring \
    zip \
    pdo_sqlite \
    pdo_mysql

# Installiere Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Installiere Node.js und npm
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && rm -rf /var/lib/apt/lists/*

# Setze Arbeitsverzeichnis
WORKDIR /workspaces/fim

# Setze Benutzerrechte
RUN chown -R $USERNAME:$USERNAME /workspaces/fim

# Wechsle zu Nicht-Root-Benutzer
USER $USERNAME

# Exponiere Port (für Laravel Development Server)
EXPOSE 8000

# Standard-Befehl für Dev Container (bash für interaktive Entwicklung)
CMD ["/bin/bash"]