# EIMAD — Gestor de Videos

A local network web application for managing and playing video files via a browser interface. Built with Laravel, it acts as a control panel that triggers video playback on the host machine using VLC or omxplayer — useful for setups like a Raspberry Pi or any machine acting as a media player on a local network.

## Features

- Browse and manage a library of video streams
- Trigger playback via VLC or omxplayer through the web interface
- Multi-account support
- Sync library with a local folder
- Reorder videos in the playlist

## Requirements

- PHP 8+
- Composer
- MySQL
- Node.js + Yarn
- VLC or omxplayer installed on the host machine

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`, then:

```bash
php artisan migrate --seed
yarn && yarn dev
php artisan serve
```

## Usage

Run the Laravel server on the machine that will play the videos. Access the web interface from any device on the same local network. Log in and use the dashboard to manage and play your video library.

## Tech Stack

- **Backend:** Laravel 9
- **Frontend:** Bootstrap 5 (Sneat template), Blade
- **Players:** VLC, omxplayer
