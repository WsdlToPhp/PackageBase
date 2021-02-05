# UPGRADE FROM 4.0 to 5.0

Internal properties and methods of [AbstractStructArrayBase](/src/AbstractStructArrayBase.php) are now private:
- Properties:
  - $internArray
  - $internArrayIsArray
  - $internArrayOffset
- Methods:
  - getInternArray
  - setInternArray
  - getInternArrayOffset
  - initInternArray
  - setInternArrayOffset
  - getInternArrayIsArray
  - setInternArrayIsArray

You don't have to manually call `initInternArray` before looping on the current object, it's done automatically.
