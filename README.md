# Creation of an API for an E-commerce with pure PHP (without using libraries) 🛒🛍️🌐📦

### This project aims to create the back-end of an e-commerce platform with Pure PHP (without using libraries). The challenge of implementing two project modeling standards was also accepted, namely the singleton and factory standards, the The objective was to simulate a day-to-day situation, applying the concept of modeling design patterns, it is worth highlighting the infrastructure and deployment part with the help of Docker, thank you for being in my repository, below is more information about the application.

<details>
  <summary>🔎 <i>What is a singleton project modeling pattern?</i> ℹ️</summary>
The Singleton design pattern is a creational pattern used in software engineering to ensure that a class has only one instance and provides a global point of access to that instance. This is particularly useful in scenarios where having multiple instances of a class would lead to inconsistent states or would be unnecessary and wasteful of resources. The Singleton pattern is widely used for managing shared resources such as configuration settings, connection pools, or logging mechanisms.

To implement the Singleton pattern, a class must ensure that only one instance can be created. This is typically achieved by making the class's constructor private or protected and providing a static method that returns the sole instance. The static method checks if an instance already exists; if it does not, it creates one, ensuring that the same instance is reused for subsequent calls. This ensures that only one instance of the class is in use throughout the application's lifecycle.

An important aspect of the Singleton pattern is thread safety. In a multi-threaded environment, multiple threads could attempt to create an instance simultaneously, leading to multiple instances. To prevent this, various techniques such as synchronized methods, double-checked locking, or using an initialization-on-demand holder idiom can be employed. These methods ensure that the Singleton instance is created in a thread-safe manner, preserving the integrity and consistency of the instance.

While the Singleton pattern is beneficial in many cases, it is also criticized for potential drawbacks. One major concern is that it can introduce global state into an application, making it harder to test and maintain. Additionally, Singleton can violate the single responsibility principle by controlling its own lifecycle and also managing its state. Despite these criticisms, when used appropriately, the Singleton pattern remains a powerful tool in a software engineer's toolkit for managing shared resources effectively.
</details>

<details>
  <summary>🔎 <i>What is a factory project modeling pattern?</i> ℹ️ </summary>
The Factory Method pattern is a creational design pattern that provides an interface for creating objects in a superclass but allows subclasses to alter the type of objects that will be created. This pattern is particularly useful when a class cannot anticipate the class of objects it must create. By defining an interface for creating an object, but letting subclasses decide which class to instantiate, the Factory Method pattern promotes loose coupling and enhances flexibility in the codebase.

One of the primary advantages of the Factory Method pattern is that it encourages the principle of "programming to an interface, not an implementation." This means that the client code interacts with an interface or abstract class, and not the concrete classes directly. As a result, the client code is not affected by changes to the concrete classes and can work with any object that adheres to the expected interface. This makes the system more extensible, as new types of objects can be introduced with minimal changes to the existing code.

The Factory Method pattern also helps in managing and organizing the creation process of objects, especially when the creation process is complex. By encapsulating the object creation logic in a dedicated method, it simplifies the code and separates the responsibilities of object creation from the main business logic. This can lead to a more modular and maintainable codebase, as the object creation code can be modified independently of the business logic.

However, it is important to note that the Factory Method pattern can also introduce some complexity, particularly when dealing with numerous subclasses and factory methods. This might make the codebase harder to understand and maintain if not managed properly. Nonetheless, when used appropriately, the Factory Method pattern is a powerful tool for designing flexible and scalable object-oriented systems, providing a robust way to manage object creation and enhance the adaptability of the software.
</details>

## 🧠💡 Main Skills Involved
<div align='center'>
   <p align='left'>
    <a href="https://skillicons.dev">
      <img src="https://skillicons.dev/icons?i=php,mysql,docker,git" />
    </a>
   </p>
 </div>

<hr>

## 📁🏗️ Folder Structure Project
- <i>Root</i> - Project management and infrastructure, environment configurations and application content.
- <i>Validation</i> - Verification of common situations, responsible for deciding the path of information.
- <i>Utils</i> - Settings and project structure information setter and getter.
- <i>Database</i> - Communication, Structuring and Connection with data storage service.
- <i>Factories</i> - Creator of "products" with distinct characteristics, used to facilitate and organize mass production lines.
- <i>Services</i> - Provision of resources for use throughout the system
- <i>Models</i> - Insertion, search, editing and deletion of information using SQL instructions.
- <i>Controllers</i> - Treatment and verification of the veracity of the information received, contact "Models" if everything is ok.
<hr>

## Routes 🗺️ 🛤️
| ↗️ Route          | ⚙️ Method | 📝 Description                                           |🔒Private Route|
| -------------- |--------|----------------------------------------------------- |-----------|
| `/users/add`   | POST |Creating a new user within the system.                 |`false` |
| `/users/signin`   | POST |Session creator within the system, making it possible to enter private routes.|`false` |
| `/products/getall`   | GET | Responsible for presenting all products available in the system.|`false` |
