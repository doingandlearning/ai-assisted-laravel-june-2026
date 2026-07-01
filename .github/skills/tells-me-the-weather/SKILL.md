---
name: tells-me-the-weather
description: 'Provide current weather or a short forecast for a requested location. Use when the user asks about the weather, temperature, rain, forecast, conditions, or what it is like outside in a city or region. Triggers: "weather", "forecast", "temperature", "rain", "what is it like outside", "is it going to rain".'
argument-hint: 'Describe the location and timeframe, for example: "Current weather in Nashville" or "Tomorrow morning forecast for Dublin in Celsius".'
user-invocable: true
---

# Tells Me The Weather

## What This Skill Produces

- A short, direct weather answer for the requested location.
- A response that distinguishes between current conditions and forecasted conditions.
- A concise follow-up when key inputs are missing or the data source is unavailable.

## When to Use

- The user asks for current weather.
- The user asks for a forecast for a place and time.
- The user asks whether it will rain, be hot, or need a jacket in a specific location.

## Inputs You Should Collect

- Location: city, region, ZIP/postal code, or a clearly named place.
- Timeframe: now, today, tonight, tomorrow, or a specific date/time.
- Units or locale preference when relevant: Celsius/Fahrenheit, mph/kph.

If the user did not provide enough detail, ask only for the minimum missing information.

## Procedure

### 1) Classify the Request

1. Determine whether the user wants:
   - Current conditions.
   - A forecast.
   - A decision-oriented answer such as rain risk or clothing guidance.
2. Extract any location, date, and unit preference already present.

Quality gate:

- The requested place and time window are explicit, or exactly one short clarification question is ready.

### 2) Fill Missing Context

1. If the location is missing, ask for it.
2. If the timeframe is ambiguous, ask whether they mean current weather or a forecast.
3. If units matter and were not provided, infer from locale when reasonable; otherwise keep the answer simple and note the units used.

Quality gate:

- There is enough information to look up the weather without making unsafe assumptions.

### 3) Retrieve Weather Data

1. Use the best available web, browser, or approved data-source tool to retrieve weather information.
2. Prefer sources that show:
   - Observation or forecast time.
   - Temperature.
   - Conditions.
   - Precipitation chance when relevant.
3. If multiple sources disagree materially, prefer the most recent and authoritative source and say that briefly.

Quality gate:

- The weather details are recent enough for the request and tied to the requested location.

### 4) Answer at the Right Level

1. Start with the direct answer in one sentence.
2. Add the most decision-useful details:
   - Temperature and feels-like.
   - Sky/condition summary.
   - Rain or storm risk.
   - Notable wind or severe weather when relevant.
3. Keep the reply short unless the user asked for more detail.

Quality gate:

- The first sentence alone answers the user's question.

### 5) Handle Limits Clearly

1. If no tool or data source is available, say that plainly.
2. Ask for a narrower location or timeframe if that is the blocker.
3. Do not invent weather data.

Quality gate:

- Any limitation is explicit, and the next step for the user is obvious.

## Decision Points

### If the User Only Asks "What's the Weather?"

- Ask for the location.
- If needed, also ask whether they want current conditions or a forecast.

### If the User Asks a Travel or Clothing Question

- Answer with weather first.
- Then convert that into a practical recommendation such as umbrella, jacket, or heat caution.

### If the User Asks for a Multi-Day Forecast

- Summarize the trend instead of listing excessive hourly detail.
- Call out the warmest/coldest day and any meaningful precipitation risk.

### If the Request Is Time-Sensitive or Safety-Critical

- Prioritize severe weather, storms, heat, cold, wind, flooding, or air-quality impacts when those are available.

## Completion Checks

Before finishing, confirm all are true:

- The answer matches the requested place.
- The answer matches the requested time window.
- Units are understandable.
- The response clearly distinguishes observed weather from forecasted weather.
- No weather details were guessed.

## Example Prompts

- Current weather in Nashville.
- Will it rain in Seattle tomorrow afternoon?
- Give me a two-day forecast for Barcelona in Celsius.
- Do I need a jacket in Chicago tonight?
