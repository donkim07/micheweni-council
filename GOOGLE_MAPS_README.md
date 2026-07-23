# Google Maps Integration

This project uses Google Maps for displaying interactive maps. To make the maps work properly, you need to set up a Google Maps API key.

## Setting Up Google Maps API Key

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the following APIs:
   - Maps JavaScript API
   - Geocoding API (if you need geocoding features)
   - Places API (if you need places search features)
4. Create an API key in the Credentials section
5. Restrict the API key to your domains for security (recommended)

## Adding the API Key to Your Project

1. Open the `.env` file in the root of your project
2. Find or add the following line:
   ```
   GOOGLE_MAPS_API_KEY=YOUR_API_KEY_HERE
   ```
3. Replace `YOUR_API_KEY_HERE` with your actual Google Maps API key

## Security Considerations

- The API key is stored in the `.env` file, which is not committed to the repository
- The key is fetched from the backend via an API endpoint, so it's not exposed in your frontend code
- Make sure to restrict your API key to your domains in the Google Cloud Console

## Troubleshooting

If the maps are not loading:

1. Check the browser console for errors
2. Verify that your API key is correctly set in the `.env` file
3. Make sure the necessary APIs are enabled in your Google Cloud Console project
4. Check that your API key has the correct restrictions (not too restrictive)

## API Endpoints

The application uses the following endpoint to fetch the Google Maps API key:

```
GET /api/google-maps-api-key
```

This endpoint returns a JSON response with the API key:

```json
{
  "api_key": "your-api-key-here"
}
``` 