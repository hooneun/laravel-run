# 01. 프로젝트 초기 설정

## 🎯 목표
Laravel + React + TypeScript 기반의 BookmarkHub 프로젝트 기본 구조를 설정하고 개발 환경을 구축합니다.

## 📋 요구사항
### 기능적 요구사항
- Laravel 12.x 프로젝트 구조 설정
- React 19 + TypeScript 프론트엔드 환경 구축
- Inertia.js SSR 설정
- 기본 개발 도구 설정 (ESLint, Prettier, Pest)

### 기술적 요구사항
- PHP 8.2+ 환경
- Node.js 18+ 환경
- SQLite 개발 데이터베이스
- Vite 번들러 설정

## 🛠️ 구현 사항

### Backend 설정
- [x] Laravel 12.x 프로젝트 초기 설정
- [x] Inertia.js 서버사이드 설정
- [x] SQLite 데이터베이스 설정
- [x] Queue 시스템 설정 (database driver)
- [x] 기본 미들웨어 설정

### Frontend 설정
- [x] React 19 + TypeScript 설정
- [x] Tailwind CSS v4 설정
- [x] shadcn/ui 컴포넌트 라이브러리 설정
- [x] Vite 개발 서버 설정
- [x] ESLint + Prettier 설정

### 개발 도구 설정
- [x] Pest PHP 테스팅 프레임워크 설정
- [x] Laravel Pint (PHP CS Fixer) 설정
- [x] TypeScript 설정 최적화
- [x] 개발 스크립트 설정 (`composer dev`)

## 📁 파일 구조

```
laravel-run/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │       └── HandleInertiaRequests.php
│   ├── Models/
│   └── Providers/
├── database/
│   ├── database.sqlite
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── js/
│       ├── app.tsx
│       ├── bootstrap.ts
│       ├── components/
│       │   └── ui/
│       ├── layouts/
│       ├── pages/
│       └── types/
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── api.php
├── package.json
├── composer.json
├── vite.config.js
├── tailwind.config.js
├── tsconfig.json
└── .env
```

## ✅ 완료 기준
- [x] `composer dev` 명령어로 전체 개발 서버가 실행됨
- [x] `npm run dev` Vite 개발 서버가 정상 작동함
- [x] TypeScript 컴파일 에러가 없음
- [x] ESLint 규칙이 적용됨
- [x] 기본 페이지 (welcome, login, register)가 표시됨
- [x] SQLite 데이터베이스 연결이 정상 작동함
- [x] Inertia.js SSR이 활성화됨

## 🧪 테스트
- [x] `composer test` - 기본 테스트 실행 확인
- [x] `npm run lint` - 린팅 규칙 적용 확인
- [x] `npm run types` - TypeScript 타입 체크 확인
- [x] 브라우저에서 기본 페이지 접근 확인

## 📚 참고자료
- [Laravel 12.x Documentation](https://laravel.com/docs/11.x)
- [Inertia.js Documentation](https://inertiajs.com/)
- [React TypeScript Documentation](https://react-typescript-cheatsheet.netlify.app/)
- [Tailwind CSS v4](https://tailwindcss.com/docs)
- [shadcn/ui Components](https://ui.shadcn.com/)

---
**상태**: ✅ 완료  
**소요 시간**: 1일  
**담당자**: 개발팀  
**우선순위**: 높음