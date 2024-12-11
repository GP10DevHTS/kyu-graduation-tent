// resources/js/pusher-listener.js
import Pusher from 'pusher-js';

class PusherListener {
    constructor() {
        this.pusher = null;
        this.channel = null;
        this.initPusher();
    }

    initPusher() {
        // Enable logging for debugging
        Pusher.logToConsole = true;

        // Initialize Pusher with configuration from .env
        this.pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            encrypted: true,
            authEndpoint: '/broadcasting/auth', // Laravel echo authentication endpoint
        });
    }

    subscribeToGroupChannel(groupId) {
        // Unsubscribe from previous channel if exists
        if (this.channel) {
            this.pusher.unsubscribe(this.channel.name);
        }

        // Subscribe to the private group channel
        this.channel = this.pusher.subscribe(`private-group-${groupId}`);

        // Listen for new group messages
        this.channel.bind('new-group-message', (data) => {
            // Broadcast event to the entire application
            window.dispatchEvent(new CustomEvent('new-group-message', { 
                detail: data 
            }));

            // Optional: console log for debugging
            console.log('New Group Message Received:', data);
        });

        // Handle subscription success
        this.channel.bind('pusher:subscription_succeeded', () => {
            console.log(`Subscribed to group channel: ${groupId}`);
        });

        // Handle subscription error
        this.channel.bind('pusher:subscription_error', (status) => {
            console.error('Subscription error:', status);
        });
    }

    // Method to disconnect and clean up
    disconnect() {
        if (this.pusher) {
            this.pusher.disconnect();
        }
    }
}

// Export a singleton instance
export default new PusherListener();