# BasicAlts - PocketMine Plugin

**BasicAlts** is a PocketMine plugin that allows administrators and moderators to view secondary accounts (alts) that a player has used on the server.

## Features

- **Automatic Detection**: Automatically identifies secondary accounts based on the player's ClientRandomID, DeviceID, and SelfSignedID.
- **Data Logging**: Stores information about secondary accounts for future reference.

## Usage

### Commands

- `/alts <player>`: Displays a list of secondary accounts associated with the specified player.

### Permissions

- `basicalts.command`: Allows users to use the BasicAlts commands. By default, this permission is assigned only to operators (`op`).
